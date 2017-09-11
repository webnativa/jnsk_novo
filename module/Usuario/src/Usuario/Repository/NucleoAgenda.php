<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\NucleoAgenda as Entity;

class NucleoAgenda extends EntityRepository {
    
    public function getAgendaPorNucleoFront($ids_nucleos = array(), $filters) {
        
        unset($filters['q_nome'], $filters['mes']);
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        if(!$ids_nucleos){
            return array();
        }
        
        $stmt = "SELECT at FROM $this->_entityName at Join at.agenda AG Where "
                . " at.nucleo IN($ids_nucleos) And AG.data_cancelamento Is Null "
                . " $filter_itens Group By AG.id Order By AG.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }
    
    public function getAgendaPorNucleo($ids_nucleos = array()) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.agenda DOC Where "
                . " AT.nucleo IN($ids_nucleos) And DOC.data_cancelamento Is Null "
                . " Group By DOC.id  Order By DOC.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(\Usuario\Entity\Agenda $agenda, \Projeto\Entity\Nucleo $nucleo) {

        $NucleoAgenda = new Entity();

        $NucleoAgenda->setAgenda($agenda);
        $NucleoAgenda->setNucleo($nucleo);

        $agenda->addNucleoAgenda($NucleoAgenda);

        $this->_em->persist($agenda);
        $this->_em->flush();
    }

    public function removeNucleoAgenda($usuario_id) {
        $this->_em
                ->createQuery("delete from $this->_entityName m where m.agenda = {$usuario_id}")
                ->execute();
    }

}
