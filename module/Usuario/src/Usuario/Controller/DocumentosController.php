<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Usuario\Entity\Documento as Entity;
use Usuario\Form\DocumentoForm as FormPadrao;
use Usuario\Validator\DocumentoValitador as ValidatorForm;

class DocumentosController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'documentos';
    }

    protected function getFolderView() {
        return 'usuario/documentos';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Usuario\Entity\Documento");
    }

    public function filaAction() {

        $em = $this->getEntityManager();

        $repoFilaDocumento = $em->getRepository("Usuario\Entity\FilaDocumento");

        $fila = $repoFilaDocumento->getAll();
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $sendgrid = new \SendGrid('chicosilva', 'ledro5478wer');

        foreach ($fila as $item) {

            if (!$item->getEnviado()) {

                $item->setEnviado(1);
                $item->setDataEnvio();
                $documento = $this->getRepository()->find($item->getDocumento());

                $renderer->usuario = $item->getUsuario();
                $renderer->documento = $documento;
                $content = $renderer->render('usuario/documentos/newsletter');

                $users = $repoFilaDocumento->getByUsuario($item->getUsuario()->getId());

                foreach ($users as $user) {

                    $user->setEnviado(1);
                    $user->setDataEnvio();
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush();
                }

                $email = new \SendGrid\Email();

                $email
                        ->addTo($item->getUsuario()->getEmail())
                        ->setFromName('FECOAGRO LEITE MINAS')
                        ->setFrom(_EMAIL_)
                        ->setSubject("{$documento->getNome()}")
                        ->setText($content)
                        ->setHtml($content);

                try {
                    $sendgrid->send($email);
                } catch (Exception $ex) {
                    
                }
            }
        }

        exit;
    }

    public function envioFilaDocumentoAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $repoFilaDocumento = $em->getRepository("Usuario\Entity\FilaDocumento");
        $repoUsuario = $em->getRepository("Usuario\Entity\Usuario");

        $dados = array();
        $id = $this->params()->fromPost('documento');

        $documento = $this->getRepository()->find($id);

        $nucleos = $documento->getNucleoDocumento();
        $perfis = $documento->getPerfilDocumento();

        $arrNucleos = array();

        foreach ($nucleos as $nucleo) {
            $arrNucleos[] = $nucleo->getNucleo()->getId();
        }

        $arrPerfis = array();

        foreach ($perfis as $perfil) {
            $arrPerfis[] = $perfil->getPerfil()->getId();
        }

        $perfisIds = implode(',', $arrPerfis);

        $usuarios = $repoUsuario->getUsuarioPorPerfil($perfisIds);

        foreach ($usuarios as $item) {
            $repoFilaDocumento->save($dados = ['usuario' => $item, 'documento' => $id,]);
        }

        $documento->setEnviado(1);
        $this->getEntityManager()->persist($documento);
        $this->getEntityManager()->flush();

        $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) a fila de envio com sucesso!");

        return $this->redirect()->toRoute($this->getSegmentRoute());
    }

    public function indexAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $nome = $this->params()->fromQuery('nome', null);

        $query = $this->getRepository()->getAll($nome);

        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return (new ViewModel())
                        ->setVariable('titulo', Entity::getPluralName())
                        ->setVariable('registros', $paginator)
                        ->setVariable('paramsQuery', $this->params())
                        ->setVariable('routeController', $this->getSegmentRoute());
    }

    public function novoAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $request = $this->getRequest();

        $form = new FormPadrao($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $documento = $this->getRepository()->save($form->getData());

                $repositoryNucleoDocumento = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoDocumento");
                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoDocumento->save($documento, $nucleo);
                }

                //Perfils
                $repositoryPerfilDocumento = $this->getEntityManager()->getRepository("Usuario\Entity\PerfilDocumento");
                $repositoryPerfil = $this->getEntityManager()->getRepository("Usuario\Entity\Perfil");

                $perfils = $this->params()->fromPost('perfil', array());

                foreach ($perfils as $perfil_id) {

                    $nucleo = $repositoryPerfil->find($perfil_id);
                    $repositoryPerfilDocumento->save($documento, $nucleo);
                }

                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true)
                                ->setVariable('routeController', $this->getSegmentRoute())
                                ->setTemplate($this->getFolderView() . '/novo');
            }
        }

        $dados = ['form' => $form,
            'titulo' => 'Adicionar ' . Entity::getVerboseName(),
            'routeController' => $this->getSegmentRoute()
        ];

        return $dados;
    }

    public function editarAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $id = (int) $this->params()->fromRoute('id', false);

        $registro = $this->getRepository()->find($id);

        $request = $this->getRequest();

        $form = new FormPadrao($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $documento = $this->getRepository()->save($form->getData());

                $repositoryNucleoDocumento = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoDocumento");

                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $repositoryNucleoDocumento->removeNucleoDocumento($documento->getId());

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoDocumento->save($documento, $nucleo);
                }


                //Perfis

                $repositoryPerfilDocumento = $this->getEntityManager()->getRepository("Usuario\Entity\PerfilDocumento");

                $repositoryPerfil = $this->getEntityManager()->getRepository("Usuario\Entity\Perfil");

                $repositoryPerfilDocumento->removePerfilDocumento($documento->getId());

                $perfis = $this->params()->fromPost('perfil', array());

                foreach ($perfis as $perfil_id) {

                    $perfil = $repositoryPerfil->find($perfil_id);
                    $repositoryPerfilDocumento->save($documento, $perfil);
                }



                $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " editado(a) com sucesso!");

                return $this->redirect()->toRoute($this->getSegmentRoute());
            } else {

                return (new ViewModel())
                                ->setVariable('form', $form)
                                ->setVariable('erro', true)
                                ->setVariable('registro', $registro)
                                ->setVariable('routeController', $this->getSegmentRoute())
                                ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                                ->setTemplate($this->getFolderView() . '/novo');
            }
        }

        $hydrator = new DoctrineHydrator($this->getEntityManager(), get_class($registro));
        $form->setHydrator($hydrator);
        $form->bind($registro);

        return (new ViewModel())
                        ->setVariable('form', $form)
                        ->setVariable('registro', $registro)
                        ->setVariable('routeController', $this->getSegmentRoute())
                        ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                        ->setTemplate($this->getFolderView() . '/novo');
    }

    public function removerAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $id = (int) $this->params()->fromRoute('id', 0);

        $registro = $this->getRepository()->find($id);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $registro->setDataCancelamento();
            $this->getEntityManager()->persist($registro);
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " removido(a) com sucesso!");
            return $this->redirect()->toRoute($this->getSegmentRoute());
        }

        return (new ViewModel())
                        ->setVariable('registro', $registro)
                        ->setVariable('routeController', $this->getSegmentRoute())
                        ->setVariable('titulo', 'Remover ' . Entity::getVerboseName());
    }

}
