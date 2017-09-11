<?php 

namespace Site\Controller; 

use Zend\Mvc\Controller\AbstractActionController;  
use Zend\View\Model\ViewModel; 

class IndexController extends AbstractActionController {   

    protected function getEntityManager() {
        return $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");  
    }  

    public function indexAction() {
    
        $em = $this->getEntityManager();   
        
        $noticias = $em->getRepository("Institucional\Entity\Noticia")->listagemHome();
        $banners = $em->getRepository("Marketing\Entity\Banner")->listagemHome();  
        $videos = $em->getRepository("Institucional\Entity\Video")->listagemHome();
        $eventos = $em->getRepository("Usuario\Entity\Agenda")->listagemHome();
    
        $cooperativas = $em->getRepository("Cooperativa\Entity\Cooperativa")->listagemHome();  
    
        return (new ViewModel())   
                        ->setVariable('banners', $banners) 
                        ->setVariable('eventos', $eventos) 
                        ->setVariable('cooperativas', $cooperativas)   
                        ->setVariable('videos', $videos)   
                        ->setVariable('noticias', $noticias);  
    }
}  
