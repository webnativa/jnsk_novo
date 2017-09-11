<?php

namespace Marketing\Repository;

use Doctrine\ORM\EntityRepository;
use Marketing\Entity\Banner as Entity;

class Banner extends EntityRepository {
    
    
    public function getAll($nome = null) {
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id DESC";
        
        if($nome){
            $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.email Like '{$nome}%' ORDER BY q.email ASC";
        }
        
        return $this->_em->createQuery($stmt);
        
    }
    
    public function listagemHome() {
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id DESC";
        
        return $this->_em->createQuery($stmt)->setMaxResults(5)->execute();
        
    }
    
    public function save(array $data) {
       
        if (!$data['id'] || is_null($data['id'])) {
            
            $entity = new Entity();
            
        } else {
            $entity = $this->_em->find("{$this->_entityName}", (int) $data['id']);
            if ($entity === null) {
                throw new \Exception('Registro não encotrado!');
            }
            
            if(empty($data['arquivo']) || is_null($data['arquivo'])){
                
                $data['arquivo'] = $entity->getArquivo();
            }
            
        }
        
        $entity = \Keep\Helper\Configurator::configure($entity, $data);
   
        $this->_em->persist($entity);
        $this->_em->flush();
        
        return $entity;
    }

}
