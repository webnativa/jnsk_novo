<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Usuario\Entity\Usuario as Entity;
use Usuario\Form\UsuarioForm;
use Usuario\Validator\UsuarioValitador as ValidatorForm;

class UsuariosController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'usuarios';
    }

    protected function getFolderView() {
        return 'usuario/usuarios';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Usuario\Entity\Usuario");
    }

    public function indexAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());
                
        $query = $em->getRepository("Usuario\Entity\Usuario")->getAll($this->params()->fromQuery());
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return (new ViewModel())
                        ->setVariable('titulo', Entity::getPluralName())
                        ->setVariable('registros', $paginator)
                        ->setVariable('paramsQuery', $this->params())
                        ->setVariable('cooeprativas', $em->getRepository("Cooperativa\Entity\Cooperativa")->getAll()->execute())
                        ->setVariable('perfis', $em->getRepository("Usuario\Entity\Perfil")->getAll()->execute())
                        ->setVariable('nucleos', $em->getRepository("Projeto\Entity\Nucleo")->getAll()->execute())
                        ->setVariable('routeController', $this->getSegmentRoute());
    }

    public function novoAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $request = $this->getRequest();

        $form = new UsuarioForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuario = $this->getRepository()->save($form->getData());

                $repositoryNucleoUsuario = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoUsuario");

                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoUsuario->save($usuario, $nucleo);
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

        $form = new UsuarioForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuario = $this->getRepository()->save($form->getData());

                $repositoryNucleoUsuario = $this->getEntityManager()->getRepository("Usuario\Entity\NucleoUsuario");

                $repositoryNucleo = $this->getEntityManager()->getRepository("Projeto\Entity\Nucleo");

                $repositoryNucleoUsuario->removeNucleoUsuario($usuario->getId());

                $nucleos = $this->params()->fromPost('nucleo', array());

                foreach ($nucleos as $nucleo_id) {

                    $nucleo = $repositoryNucleo->find($nucleo_id);
                    $repositoryNucleoUsuario->save($usuario, $nucleo);
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
