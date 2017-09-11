<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VideosController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function indexAction() {
        
        $em = $this->getEntityManager();
        $query = $em->getRepository("Institucional\Entity\Video")->getAll();
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
                
        return (new ViewModel())
                        ->setVariable('videos', $paginator);
    }

    public function detalhesAction() {

        $em = $this->getEntityManager();

        $id = (int) $this->params()->fromRoute('id', false);

        $video = $em->getRepository("Institucional\Entity\Video")->find($id);
        return (new ViewModel())
                        ->setVariable('video', $video);
    }

}
