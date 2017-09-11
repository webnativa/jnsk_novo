<?php

namespace Marketing\Repository;

use Doctrine\ORM\EntityRepository;
use Marketing\Entity\NewsLetter as Entity;

class NewsLetter extends EntityRepository {
    
    public function lista() {
        
                $stmt = "SELECT q FROM $this->_entityName q Where "
                        . "q.data_cancelamento IS NULL";
                
                return $this->_em->createQuery($stmt)->execute();
    }

    public function getAll($nome = null) {
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id DESC";
        
        if($nome){
            $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.email Like '{$nome}%' ORDER BY q.email ASC";
        }
        
        return $this->_em->createQuery($stmt);
        
    }
    
    public function save(array $data) {
       
        if (!$data['id'] || is_null($data['id'])) {
            
            $entity = new Entity();
        } else {
            $entity = $this->_em->find("{$this->_entityName}", (int) $data['id']);
            if ($entity === null) {
                throw new \Exception('Registro não encotrado!');
            }
        }
        
        $entity = \Keep\Helper\Configurator::configure($entity, $data);
   
        $this->_em->persist($entity);
        $this->_em->flush();
        
        return $entity;
    }

}
