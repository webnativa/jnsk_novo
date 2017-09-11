<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\Agenda as Entity;

class Agenda extends EntityRepository {

    public function listagemHome() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.publico = 1 ORDER BY q.id DESC";
        
        return $this->_em->createQuery($stmt)->setMaxResults(5)->execute();
    }

    public function listagemFront() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.publico = 1 ORDER BY q.id DESC";
        
        return $this->_em->createQuery($stmt);
    }


    public function getListagem($ids, $filters) {

        if (!$ids) {
            return array();
        }

        $qb = $this->createQueryBuilder('q');

        $qb->where($qb->expr()->isNull('q.data_cancelamento'));

        if (@$filters['mes']) {
            $mes = $filters['mes'];
            $qb->select('q')->where('month(q.data) = :month');
            $qb->setParameter('month', $mes);
        }

        $qb->andWhere('q.id IN (:ids)')->setParameter('ids', $ids);

        $qb->addOrderBy('q.data', 'DESC');

        $result = $qb->getQuery()->execute();
        return $result;
    }

    public function getAll($nome = null) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL ORDER BY q.data DESC";

        if ($nome) {
            $stmt = "SELECT q FROM $this->_entityName q Where "
                    . "q.data_cancelamento IS NULL And q.nome Like '{$nome}%' ORDER BY q.data DESC";
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

        if (!array_key_exists('id', $data) || is_null($data['id']) || !$data['id']) {
            $entity->setNome($entity->getData() . ' - ' . $data['nome']);
        }

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

}
