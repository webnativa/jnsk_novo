<?php

namespace Admin\Repository;

use Doctrine\ORM\EntityRepository;
use Admin\Entity\Admin as Entity;

class Admin extends EntityRepository {

   

    public function getAll(array $filters) {
        
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        $stmt = "SELECT q FROM $this->_entityName q Where q.data_cancelamento IS NULL $filter_itens ORDER BY q.id DESC";

        return $this->_em->createQuery($stmt);
    }

    public function autoComplete($nome = null) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.nome Like '%{$nome}%' ORDER BY q.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(array $data) {

        if (!array_key_exists('id', $data) || is_null($data['id']) || $data['id'] == false) {

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
