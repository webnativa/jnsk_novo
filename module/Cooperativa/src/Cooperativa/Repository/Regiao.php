<?php

namespace Cooperativa\Repository;

use Doctrine\ORM\EntityRepository;
use Cooperativa\Entity\Regiao as Entity;
use \Cocur\Slugify\Slugify;


class Regiao extends EntityRepository {
    
    public function listagem() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.nome ASC";
        
        return $this->_em->createQuery($stmt)->execute();
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
