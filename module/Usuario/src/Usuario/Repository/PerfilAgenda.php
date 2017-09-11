<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\PerfilAgenda as Entity;

class PerfilAgenda extends EntityRepository {
    
    public function getAgendaPorPerfilFront($perfil_id) {
        
        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.agenda DOC Where "
                . " AT.perfil = $perfil_id And DOC.data_cancelamento Is Null "
                . " Group By DOC.id Order By DOC.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }
    
    
    public function getDocumentoPorPerfilAgenda($ids_docs = array(), $perfil_id) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.agenda DOC Where "
                . " AT.documento IN($ids_docs) And AT.perfil = $perfil_id And DOC.data_cancelamento Is Null "
                . " Group By DOC.id  Order By DOC.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function getAgendaPorPerfil($ids_perfils = array()) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.agenda DOC Where "
                . " AT.perfil IN($ids_perfils) And DOC.data_cancelamento Is Null "
                . " Group By DOC.id  Order By DOC.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(\Usuario\Entity\Agenda $agenda, \Usuario\Entity\Perfil $pefil) {

        $PerfilAgenda = new Entity();

        $PerfilAgenda->setAgenda($agenda);
        $PerfilAgenda->setPerfil($pefil);

        $agenda->addPerfilAgenda($PerfilAgenda);

        $this->_em->persist($agenda);
        $this->_em->flush();
    }

    public function removePerfilAgenda($usuario_id) {
        $this->_em
                ->createQuery("delete from $this->_entityName m where m.agenda = {$usuario_id}")
                ->execute();
    }

}
