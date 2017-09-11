<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuario\Form\RecuperarSenhaForm;
use Usuario\Form\RedefinirSenhaForm;
use Usuario\Form\LoginForm;
use Usuario\Form\UsuarioFrontForm;
use Usuario\Validator\UsuarioFrontValitador as ValidatorForm;
use Usuario\Validator\RedefinirValidator;
use Usuario\Validator\RecuperarSenhaValitador;
use Usuario\Validator\LoginValitador;
use Zend\Authentication\Storage\Session as SessionStorage;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class UsuariosController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }
    
    public function agendaAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $em = $this->getEntityManager();
        $usuario_id = $authService->getIdentity()->getId();

        $usuario = $em->getRepository("Usuario\Entity\Usuario")->find($usuario_id);

        $nucleos_usuario = $em->getRepository("Usuario\Entity\NucleoUsuario")->getNucleoPorUsuario($usuario_id);

        $arrNucleosUsuario = array();

        foreach ($nucleos_usuario as $value) {
            $arrNucleosUsuario[] = $value->getNucleo()->getId();
        }

        $eventos = $em->getRepository("Usuario\Entity\NucleoAgenda")
                ->getAgendaPorNucleoFront(implode(',', $arrNucleosUsuario), $this->params()->fromQuery());

        $arrDocs = array();

        foreach ($eventos as $doc) {
            $arrDocs[] = $doc->getAgenda()->getId();
        }
        
        $eventos = $em->getRepository("Usuario\Entity\PerfilAgenda")
                ->getAgendaPorPerfilFront($usuario->getPerfil()->getId());
        
        $arrDocs = array();

        foreach ($eventos as $doc) {
            $arrDocs[] = $doc->getAgenda()->getId();
        }
        
        $documentosArray = implode(',', $arrDocs);
        
        $eventos = $em->getRepository("Usuario\Entity\Agenda")
                ->getListagem($arrDocs, $this->params()->fromQuery());

        return (new ViewModel())
                        ->setVariable('eventos', $eventos)
                        ->setVariable('nucleos', $nucleos_usuario)
                        ->setVariable('menu', 'agenda')
                        ->setVariable('paramsQuery', $this->params())
                        ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                        ->setVariable('em', $em);
    }
    
    public function documentosAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $em = $this->getEntityManager();
        $usuario_id = $authService->getIdentity()->getId();

        $usuario = $em->getRepository("Usuario\Entity\Usuario")->find($usuario_id);

        $nucleos_usuario = $em->getRepository("Usuario\Entity\NucleoUsuario")->getNucleoPorUsuario($usuario_id);

        $arrNucleosUsuario = array();

        foreach ($nucleos_usuario as $value) {
            $arrNucleosUsuario[] = $value->getNucleo()->getId();
        }

        $documentos = $em->getRepository("Usuario\Entity\NucleoDocumento")
                ->getDocumentoPorNucleo(implode(',', $arrNucleosUsuario), $this->params()->fromQuery());

        $arrDocs = array();

        foreach ($documentos as $doc) {
            $arrDocs[] = $doc->getDocumento()->getId();
        }
        
        $documentos = $em->getRepository("Usuario\Entity\PerfilDocumento")
                ->getDocumentoPorPerfilEDocumentos($usuario->getPerfil()->getId());
        
        $arrDocs = array();

        foreach ($documentos as $doc) {
            $arrDocs[] = $doc->getDocumento()->getId();
        }
        
        $documentosArray = implode(',', $arrDocs);
        
        $query = $em->getRepository("Usuario\Entity\Documento")
                ->getListagem($documentosArray, $this->params()->fromQuery());
        
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();
        
        if($paginator){
            
            $page = (int) $this->params()->fromQuery('page');
            if ($page) {
                $paginator->setCurrentPageNumber($page);
            }
        }else{
            $paginator = array();
        }
        
        
        return (new ViewModel())
                        ->setVariable('documentos', $paginator)
                        ->setVariable('nucleos', $nucleos_usuario)
                        ->setVariable('menu', 'documentos')
                        ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                        ->setVariable('paramsQuery', $this->params())
                        ->setVariable('em', $em);
    }
    
    
    
    public function detalhesAgendaAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', false);
        $agenda = $em->getRepository("Usuario\Entity\Agenda")->find($id);

        return (new ViewModel())
                        ->setVariable('agenda', $agenda)
                        ->setVariable('menu', 'agenda')
                        ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                        ->setVariable('em', $em);
    }
    
    public function detalhesDocumentoAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', false);
        $documento = $em->getRepository("Usuario\Entity\Documento")->find($id);

        return (new ViewModel())
                        ->setVariable('documento', $documento)
                        ->setVariable('menu', 'documentos')
                        ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                        ->setVariable('em', $em);
    }

    public function editarAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $em = $this->getEntityManager();
        $id = $authService->getIdentity()->getId();

        $repositorioUsuario = $em->getRepository("Usuario\Entity\Usuario");

        $registro = $repositorioUsuario->find($id);

        $request = $this->getRequest();

        $form = new UsuarioFrontForm($this->getEntityManager());

        if ($request->isPost()) {

            $validadeForm = new ValidatorForm();
            $validadeForm->setEm($em);
            $validadeForm->setEdicao(true);
            $validadeForm->setSenhaObrigatoria(false);

            $form->setInputFilter($validadeForm->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $dados = $form->getData();
                $dados['id'] = $id;

                $repositorioUsuario->updateFront($dados);
                $this->flashMessenger()->addSuccessMessage("Dados editados com sucesso!");

                return $this->redirect()->toRoute('usuarios_front', array('action' => 'editar'));
            } else {

                return (new ViewModel())
                        ->setVariable('form', $form)
                        ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                        ->setVariable('usuario', $registro);
            }
        }

        $hydrator = new DoctrineHydrator($this->getEntityManager(), get_class($registro));
        $form->setHydrator($hydrator);
        $form->bind($registro);

        return (new ViewModel())
                    ->setVariable('form', $form)
                    ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                    ->setVariable('usuario', $registro);
    }

    private function adapterUsuario($cpf, $senha) {

        $em = $this->getEntityManager();

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        $adapter = $authService->getAdapter();

        $options = new \DoctrineModule\Options\Authentication;
        $options->setObjectManager($em);
        $options->setIdentityProperty('email');
        $options->setCredentialProperty('senha');
        $options->setIdentityClass('\Usuario\Entity\Usuario');
        $options->setCredentialCallable(function (\Usuario\Entity\Usuario $user, $passwordGiven) {
            return (new \Usuario\Entity\Usuario())->hashPassword($user, $passwordGiven);
        });

        $adapter->setIdentityValue($cpf);
        $adapter->setCredentialValue($senha);

        $adapter->setOptions($options);

        $authResult = $authService->authenticate();

        return $authResult;
    }

    public function loginAction() {
        
        $request = $this->getRequest();

        $form = new LoginForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new LoginValitador())->getInputFilter());
            $form->setData($request->getPost());

            $senha = $form->get('senha')->getValue();

            $authResult = $this->adapterUsuario($form->get('cpf')->getValue(), $senha);

            if ($form->isValid() && $authResult->isValid()) {

                return $this->redirect()->toRoute('usuarios_front', array('action' => 'documentos'));
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true);
            }
        }

        return (new ViewModel())
                        ->setVariable('form', $form);
    }

    public function senhaAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
        }

        $id = $authService->getIdentity()->getId();

        $em = $this->getEntityManager();

        $request = $this->getRequest();

        $form = new RedefinirSenhaForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('menu', 'senha')
                ->setVariable('categorias', $em->getRepository("Usuario\Entity\Categoria")->getAll()->execute())
                ->setVariable('form', $form);

        if ($request->isPost()) {

            $validadeForm = new RedefinirValidator();

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuario = $em->getRepository('Usuario\Entity\Usuario')->find($id);

                $senha = $form->get('senha')->getValue();

                $usuario->setSenha($senha);
                $em->persist($usuario);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage("Senha alterada com sucesso!");
                return $this->redirect()->toRoute('usuarios_front', array('action' => 'senha'));
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

    public function sairAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('front'));

        if ($this->identity()) {
            $authService->clearIdentity();
        }
        
        return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
    }

    public function recuperarSenhaAction() {

        $em = $this->getEntityManager();

        $request = $this->getRequest();
        $form = new RecuperarSenhaForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form);

        if ($request->isPost()) {

            $validadeForm = new RecuperarSenhaValitador();
            $validadeForm->setEm($em);

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $email = $form->get('email')->getValue();

                $usuario = $em->getRepository('Usuario\Entity\Usuario')->findOneBy(array('email' => $email));

                $usuario->setToken();
                $em->persist($usuario);
                $em->flush();

                $renderer = $this->getServiceLocator()->get('ViewRenderer');
                $renderer->usuario = $usuario;
                $content = $renderer->render('usuario/usuarios/email-recuperar-senha', null);

                $this->getServiceLocator()->get('KeepMail')
                        ->send($email, 'Redefinir Senha', $content);

                $this->flashMessenger()->addSuccessMessage("Para redefinir sua senha, siga as instruções enviadas para seu e-mail.");
                return $this->redirect()->toRoute('usuarios_front', array('action' => 'recuperar-senha'));
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

    public function redefinirAction() {

        $token = $this->params()->fromQuery('token');

        $em = $this->getEntityManager();

        $request = $this->getRequest();

        $form = new RedefinirSenhaForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setVariable('token', $token);

        if ($request->isPost()) {

            $validadeForm = new RedefinirValidator();

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuario = $em->getRepository('Usuario\Entity\Usuario')->findOneBy(array('token' => $token));

                if ($usuario) {

                    $senha = $form->get('senha')->getValue();

                    $usuario->setTokenNull();
                    $usuario->setSenha($senha);
                    $em->persist($usuario);
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage("Senha alterada com sucesso!");
                    return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
                }

                return $this->redirect()->toRoute('usuarios_front', array('action' => 'login'));
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

}
