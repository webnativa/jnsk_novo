<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class historiaController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function indexAction() {

        $em = $this->getEntityManager();

        $request = $this->getRequest();


    }

}
