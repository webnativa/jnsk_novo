<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\NucleoDocumento as Entity;

class NucleoDocumento extends EntityRepository {
    
    public function getDocumentoPorId($id) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.documento DOC Where "
                . " AT.documento = $id And DOC.data_cancelamento Is Null "
                . " Order By DOC.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }
    
    public function getDocumentoPorNucleo($ids_nucleos = array(), $filters) {
        
        unset($filters['q_categoria'], $filters['q_nome']);
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        if(!$ids_nucleos){
            return array();
        }
        
        $stmt = "SELECT at FROM $this->_entityName at Join at.documento DOC Where "
                . " at.nucleo IN($ids_nucleos) And DOC.data_cancelamento Is Null "
                . " $filter_itens Group By DOC.id Order By DOC.id DESC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(\Usuario\Entity\Documento $documento, \Projeto\Entity\Nucleo $nucleo) {

        $NucleoDocumento = new Entity();

        $NucleoDocumento->setDocumento($documento);
        $NucleoDocumento->setNucleo($nucleo);

        $documento->addNucleoDocumento($NucleoDocumento);

        $this->_em->persist($documento);
        $this->_em->flush();
    }

    public function removeNucleoDocumento($usuario_id) {
        $this->_em
                ->createQuery("delete from $this->_entityName m where m.documento = {$usuario_id}")
                ->execute();
    }

}
