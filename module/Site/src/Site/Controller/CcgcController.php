<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CcgcController extends AbstractActionController {

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
    }

    public function projetoAction() {

        $em = $this->getEntityManager();

        $slug = $this->getEvent()->getRouteMatch()->getParam('slug');

        $projeto = $em->getRepository("Projeto\Entity\Projeto")->findOneBy(array('slug' => $slug));

        $nucleos = $em->getRepository("Projeto\Entity\Nucleo")->listagemHome($projeto->getId());

        $arrNucleos = array();

        foreach ($nucleos as $nucleo) {
            $arrNucleos[] = $nucleo->getId();
        }

        $ids = implode(',', $arrNucleos);
        
        $membros = $em->getRepository("Projeto\Entity\Equipe")->listagemPorProjeto($ids);

        return (new ViewModel())
                        ->setVariable('titulo', $projeto->getNome())
                        ->setVariable('slug', $slug)
                        ->setVariable('projeto', $projeto)
                        ->setVariable('membros', $membros)
                        ->setVariable('tela_projeto', true)
                        ->setTemplate('site/ccgc/index')
                        ->setVariable('nucleos', $nucleos);
    }

    public function nucleoAction() {

        $slug = $this->getEvent()->getRouteMatch()->getParam('slug');

        $em = $this->getEntityManager();

        $nucleo = $em->getRepository("Projeto\Entity\Nucleo")->findOneBy(array('slug' => $slug));

        $nucleos = $em->getRepository("Projeto\Entity\Nucleo")->listagemHome($nucleo->getProjeto()->getId());

        $membros = $em->getRepository("Projeto\Entity\Equipe")->listagemPorNucleo($nucleo->getId());

        return (new ViewModel())
                        ->setVariable('titulo', $nucleo->getNome())
                        ->setVariable('slug', $slug)
                        ->setVariable('id', $nucleo->getId())
                        ->setVariable('nucleo', $nucleo)
                        ->setVariable('membros', $membros)
                        ->setVariable('projeto', $nucleo->getProjeto())
                        ->setTemplate('site/ccgc/index')
                        ->setVariable('nucleos', $nucleos);
    }

    public function equipeAction() {

        $em = $this->getEntityManager();

        $slug = $this->getEvent()->getRouteMatch()->getParam('slug');
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
                        ->setVariable('menu', 'equipe')
                        ->setTemplate('site/ccgc/equipe');
    }

}
