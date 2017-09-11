<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\PerfilDocumento as Entity;

class PerfilDocumento extends EntityRepository {
    
    
    public function getDocumentoPorPerfilEDocumentos($perfil_id) {
        
//        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.documento DOC Where "
//                . " AT.documento IN($ids_docs) And AT.perfil = $perfil_id And DOC.data_cancelamento Is Null "
//                . " Group By DOC.id  Order By DOC.id DESC";
        
        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.documento DOC Where "
                . " AT.perfil = $perfil_id And DOC.data_cancelamento Is Null "
                . " Group By DOC.id Order By DOC.id DESC";
        
        return $this->_em->createQuery($stmt)->execute();
    }
    
    public function getDocumentoPorPerfil($ids_perfils = array()) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.documento DOC Where "
                . " AT.perfil IN($ids_perfils) And DOC.data_cancelamento Is Null "
                . " Group By DOC.id  Order By DOC.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(\Usuario\Entity\Documento $documento, \Usuario\Entity\Perfil $pefil) {

        $PerfilDocumento = new Entity();

        $PerfilDocumento->setDocumento($documento);
        $PerfilDocumento->setPerfil($pefil);

        $documento->addPerfilDocumento($PerfilDocumento);

        $this->_em->persist($documento);
        $this->_em->flush();
    }

    public function removePerfilDocumento($usuario_id) {
        $this->_em
                ->createQuery("delete from $this->_entityName m where m.documento = {$usuario_id}")
                ->execute();
    }

}
