<?php

namespace Projeto\Repository;

use Doctrine\ORM\EntityRepository;
use Projeto\Entity\Equipe as Entity;
use \Cocur\Slugify\Slugify;

class Equipe extends EntityRepository {

    public function listagemPorNucleo($nucleo_id) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL and q.nucleo = $nucleo_id And q.coorporativo = 0 ORDER BY q.posicao ASC";

        return $this->_em->createQuery($stmt)->execute();
    }

    public function listagemPorProjeto($nucleos_id) {

        if (!$nucleos_id) {
            return array();
        }

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL and q.nucleo IN($nucleos_id) And q.coorporativo = 0 ORDER BY q.posicao ASC";

        return $this->_em->createQuery($stmt)->execute();
    }

    public function listagemNucleoConsorciada() {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL and q.coorporativo = 1 ORDER BY q.posicao ASC";

        return $this->_em->createQuery($stmt)->execute();
    }

    public function listagemFront($setor_id) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL and q.coorporativo = 0 ORDER BY q.posicao ASC";

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

        if ($data['nucleo']) {
            $nucleo = $this->_em->getReference('\Projeto\Entity\Nucleo', $data['nucleo']);
            $entity->setNucleo($nucleo);
        }

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

}
