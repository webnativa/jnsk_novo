<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConsorciadasController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function indexAction() {
        
        $em = $this->getEntityManager();
        $query = $em->getRepository("Cooperativa\Entity\Cooperativa")->getAll();
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        
        $regioes = $em->getRepository("Cooperativa\Entity\Regiao")->listagem();

        return (new ViewModel())
                        ->setVariable('regioes', $regioes)
                        ->setVariable('cooperadas', $paginator);
    }

    public function regiaoAction() {
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $em = $this->getEntityManager();
        $query = $em->getRepository("Cooperativa\Entity\Cooperativa")->porRegiao($id);
        
        $paginator = (new \Keep\Helper\Paginator($query))->getPaginator();

        $page = (int) $this->params()->fromQuery('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        
        $regioes = $em->getRepository("Cooperativa\Entity\Regiao")->listagem();

        return (new ViewModel())
                        ->setVariable('regioes', $regioes)
                        ->setTemplate('site/consorciadas/index')
                        ->setVariable('cooperadas', $paginator);
    }

    public function produtosAction() {

        $slug = $this->getEvent()->getRouteMatch()->getParam('slug');

        $em = $this->getEntityManager();
        $cooperadas = $em->getRepository("Cooperativa\Entity\Cooperativa")->listagemHome();

        return (new ViewModel())
                        ->setVariable('cooperadas', $cooperadas);
    }

    public function detalhesAction() {

        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        $em = $this->getEntityManager();

        $cooperada = $em->getRepository("Cooperativa\Entity\Cooperativa")->find($id);

        $cooperadas = $em->getRepository("Cooperativa\Entity\Cooperativa")->outrasCooperadas($cooperada->getId());

        return (new ViewModel())
                        ->setVariable('titulo', $cooperada->getNome())
                        ->setVariable('id', $cooperada->getId())
                        ->setVariable('cooperada', $cooperada)
                        ->setTemplate('site/consorciadas/detalhes')
                        ->setVariable('cooperadas', $cooperadas);
    }

}
