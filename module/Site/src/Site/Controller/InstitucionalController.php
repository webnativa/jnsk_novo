<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InstitucionalController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }
    
    public function cotacoesAction() {
        return (new ViewModel())->setVariable('cotacoes', null);  
    }

    public function equipeAction() {

        $em = $this->getEntityManager();

        $slug = 'central-de-compras';
        $projeto = $em->getRepository("Projeto\Entity\Projeto")->findOneBy(array('slug' => $slug));
        
        $ccgc_cooportativo = $em->getRepository("Projeto\Entity\Equipe")->listagemNucleoConsorciada();
        
        $nucleos = $em->getRepository("Projeto\Entity\Nucleo")->listagemHome($projeto->getId());

        $arrNucleos = array();

        foreach ($nucleos as $nucleo) {
            $arrNucleos[] = $nucleo->getId();
        }

        $ids = implode(',', $arrNucleos);
        $membros = $em->getRepository("Projeto\Entity\Equipe")->listagemPorProjeto($ids);
        
        return (new ViewModel())
                        ->setVariable('ccgc_cooportativo', $ccgc_cooportativo)
                        ->setVariable('membros', $membros)
                        ->setVariable('nucleos', $nucleos)
                        ->setVariable('projeto', $projeto)
                        ->setTemplate('site/ccgc/equipe');
    }
    
    public function indexAction() {

        $em = $this->getEntityManager();
        $institucionais = $em->getRepository("Institucional\Entity\Instituicao")->listagemHome();
        $pagina = $em->getRepository("Institucional\Entity\Instituicao")->find(4);

        return (new ViewModel())
                        ->setVariable('titulo', $pagina->getNome())
                        ->setVariable('id', $pagina->getId())
                        ->setVariable('pagina', $pagina)
                        ->setVariable('institucionais', $institucionais);
    }

    public function paginaAction() {

        $id = (int) $this->params()->fromRoute('id', false);

        $em = $this->getEntityManager();
        $pagina = $em->getRepository("Institucional\Entity\Instituicao")->find($id);
        $institucionais = $em->getRepository("Institucional\Entity\Instituicao")->listagemHome();

        return (new ViewModel())
                        ->setVariable('titulo', $pagina->getNome())
                        ->setVariable('id', $id)
                        ->setVariable('pagina', $pagina)
                        ->setTemplate('site/institucional/index')
                        ->setVariable('institucionais', $institucionais);
    }

}
