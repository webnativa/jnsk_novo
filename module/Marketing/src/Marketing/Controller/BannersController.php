<?php

namespace Marketing\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Marketing\Entity\Banner as Entity;
use Marketing\Form\BannerForm;
use Marketing\Validator\BannerValitador as ValidatorForm;
use Zend\Validator\File\Size;

class BannersController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    protected function getSegmentRoute() {
        return 'banners';
    }

    protected function getFolderView() {
        return 'marketing/banners';
    }

    protected function getRepository() {

        return $this->getEntityManager()->getRepository("Marketing\Entity\Banner");
    }

    public function indexAction() {
        
        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());
        
        $query = $this->getRepository()->getAll();

        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return (new ViewModel())
                        ->setVariable('titulo', Entity::getPluralName())
                        ->setVariable('registros', $paginator)
                        ->setVariable('routeController', $this->getSegmentRoute());
    }

    public function novoAction() {
        
        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());
        
        $request = $this->getRequest();

        $form = new BannerForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setVariable('routeController', $this->getSegmentRoute())
                ->setTemplate($this->getFolderView() . '/novo');

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $nonFile = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('arquivo');
                $data = array_merge(
                        $nonFile, array('arquivo' => $File['name'])
                );
                
                $size = new Size(array('max' => 8000000));

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);

                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));
                    return $ViewModel;
                } else {

                    $destino = PUBLIC_PATH . '/uploads/banners';
                    $adapter->setDestination($destino);

                    if ($adapter->receive($File['name'])) {

                        $this->getRepository()->save($data);
                        $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                        return $this->redirect()->toRoute($this->getSegmentRoute());
                    }
                }
            } else {
                return $ViewModel;
            }
        }

        return $ViewModel;
    }

    public function editarAction() {
        
        $em = $this->getEntityManager();
        (new \Keep\Helper\ControleAcesso())->controleAcesso($this, $em, $this->getSegmentRoute());
        
        $id = (int) $this->params()->fromRoute('id', false);

        $registro = $this->getRepository()->find($id);
        $request = $this->getRequest();
        $form = new BannerForm($this->getEntityManager());

        $ViewModel = (new ViewModel())
                ->setVariable('form', $form)
                ->setVariable('registro', $registro)
                ->setVariable('routeController', $this->getSegmentRoute())
                ->setVariable('titulo', 'Editar ' . Entity::getVerboseName())
                ->setTemplate($this->getFolderView() . '/novo');

        if ($request->isPost()) {

            $form->setInputFilter((new ValidatorForm())->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $nonFile = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('arquivo');
                $data = array_merge(
                        $nonFile, array('arquivo' => $File['name'])
                );
                
                if(empty($data['arquivo']) || is_null($data['arquivo'])){
                        
                        $this->getRepository()->save($data);
                        $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                        return $this->redirect()->toRoute($this->getSegmentRoute());
                }
                
                $size = new Size(array('max' => 8000000));

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);

                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));
                    return $ViewModel;
                } else {

                    $destino = PUBLIC_PATH . '/uploads/banners';
                    $adapter->setDestination($destino);

                    if ($adapter->receive($File['name'])) {
                        
                        $this->getRepository()->save($data);
                        $this->flashMessenger()->addSuccessMessage(Entity::getVerboseName() . " adicionado(a) com sucesso!");

                        return $this->redirect()->toRoute($this->getSegmentRoute());
                    }
                }
                
            } else {
                return $ViewModel;
            }
        }

        $hydrator = new DoctrineHydrator($this->getEntityManager(), get_class($registro));
        $form->setHydrator($hydrator);
        $form->bind($registro);

        return $ViewModel;
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
