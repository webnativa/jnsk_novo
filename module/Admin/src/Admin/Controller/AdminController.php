<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Admin\Entity\Admin as Entity;
use Admin\Form\AdminForm;
use Admin\Validator\AdminValitador as ValidatorForm;
use Zend\Authentication\Storage\Session as SessionStorage;
use Admin\Form\RedefinirSenhaForm;
use Admin\Validator\RedefinirValidator;

class AdminController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'admin';
    }

    protected function getFolderView() {
        return 'admin/admin';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Admin\Entity\Admin");
    }

    public function indexAction() {

        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $query = $this->getRepository()->getAll($this->params()->fromQuery());

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
//        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());

        $request = $this->getRequest();

        $form = new AdminForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $this->getRepository()->save($form->getData());

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

        $form = new AdminForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $this->getRepository()->save($form->getData());

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

    public function senhaAction() {

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('admin'));

        if (!$authService->hasIdentity()) {
            header("location:/gestao/login");
            exit;
        }

        $id = $authService->getIdentity()->getId();

        $em = $this->getEntityManager();

        $request = $this->getRequest();

        $form = new RedefinirSenhaForm($this->getEntityManager());

        $ViewModel = (new ViewModel())->setVariable('form', $form);

        if ($request->isPost()) {

            $validadeForm = new RedefinirValidator();

            $form->setInputFilter($validadeForm->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $usuario = $em->getRepository('Admin\Entity\Admin')->find($id);

                $senha = $form->get('senha')->getValue();

                $usuario->setSenha($senha);
                $em->persist($usuario);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage("Senha alterada com sucesso!");
                return $this->redirect()->toRoute('admin', array('action' => 'senha'));
            } else {

                return $ViewModel;
            }
        }

        return $ViewModel;
    }

    public function _senhaAction() {

        $em = $this->getEntityManager();

        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('admin'));

        if (!$authService->hasIdentity()) {
            header("location:/gestao/login");
            exit;
        }

        $id = $authService->getIdentity()->getId();

        $registro = $this->getRepository()->find($id);

        $request = $this->getRequest();

        $form = new AdminForm($this->getEntityManager());

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $this->getRepository()->save($form->getData());

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

}
