<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\FilaDocumento as Entity;

class FilaDocumento extends EntityRepository {
    
    public function getByUsuario($usuario_id) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.usuario = $usuario_id";

        return $this->_em->createQuery($stmt)->execute();
    }
    
    public function getAll() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.enviado = 0 Group By q.usuario ORDER BY q.id DESC";

        return $this->_em->createQuery($stmt)->setMaxResults(1)->execute();
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

        $entity->setUsuario($data['usuario']);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

}
