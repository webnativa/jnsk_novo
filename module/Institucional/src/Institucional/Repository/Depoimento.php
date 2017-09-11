<?php

namespace Institucional\Repository;

use Doctrine\ORM\EntityRepository;
use Institucional\Entity\Depoimento as Entity;
use \Cocur\Slugify\Slugify;


class Depoimento extends EntityRepository {
    
    public function ultimoDepoimento() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id DESC";
        
        return $this->_em->createQuery($stmt)->setMaxResults(1)->execute();
    }
    
    public function listagemInterna($id_atual) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.id <> $id_atual ORDER BY q.id DESC";
        
        return $this->_em->createQuery($stmt)->setMaxResults(10)->execute();
    }
    
    public function getAll($nome = null) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.id ASC";

        if ($nome) {
            $stmt = "SELECT q FROM $this->_entityName q Where "
                    . "q.data_cancelamento IS NULL And q.nome Like '{$nome}%' ORDER BY q.nome ASC";
        }

        return $this->_em->createQuery($stmt);
    }

    public function save(array $data) {

        if (!$data['id'] || is_null($data['id'])) {

            $entity = new Entity();
            
            $slugify = new Slugify();
            $entity->setSlug($slugify->slugify($data['nome']));
            
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
