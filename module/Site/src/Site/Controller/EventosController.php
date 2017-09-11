<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Form\NewsLetterForm;
use Site\Validator\NewsLetterValitador as ValidatorForm;


class EventosController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }
    
    public function indexAction() {
        
        $em = $this->getEntityManager();
        $query = $em->getRepository("Usuario\Entity\Agenda")->listagemFront();
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        
        return (new ViewModel())->setVariable('eventos', $paginator);
    }

    
    public function detalhesAction() {

        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', false);

        $evento = $em->getRepository("Usuario\Entity\Agenda")->find($id);

        return (new ViewModel())->setVariable('evento', $evento);
    }

}
