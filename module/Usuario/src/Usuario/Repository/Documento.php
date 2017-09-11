<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\Documento as Entity;

class Documento extends EntityRepository {
    
    public function getDocumentosNewsLetter($ids) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.id IN($ids) ORDER BY q.id DESC";

        return $this->_em->createQuery($stmt)->execute();
    }
    
    public function getListagem($ids, $filters) {
        
        unset($filters['at_nucleo']);
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        if(!$ids){
            return array();
        }
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL $filter_itens And q.id IN($ids) ORDER BY q.id DESC";

        return $this->_em->createQuery($stmt);
    }

    public function getAll($nome = null) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id DESC";

        if ($nome) {
            $stmt = "SELECT q FROM $this->_entityName q Where "
                    . "q.data_cancelamento IS NULL And q.nome Like '%{$nome}%' ORDER BY q.id DESC";
        }

        return $this->_em->createQuery($stmt);
    }

    public function save(array $data) {

        if (!array_key_exists('id', $data) || is_null($data['id']) || !$data['id']) {

            $entity = new Entity();
        } else {
            $entity = $this->_em->find("{$this->_entityName}", (int) $data['id']);
            if ($entity === null) {
                throw new \Exception('Registro não encotrado!');
            }
        }

        $entity = \Keep\Helper\Configurator::configure($entity, $data);

        $categoria = $this->_em->getReference('\Usuario\Entity\Categoria', $data['categoria']);
        $entity->setCategoria($categoria);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

}
