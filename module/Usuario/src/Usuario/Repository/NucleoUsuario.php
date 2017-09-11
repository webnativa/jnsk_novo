<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\NucleoUsuario as Entity;

class NucleoUsuario extends EntityRepository {
    
    
    public function getUsuariosFiltro($filters) {
        
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        $stmt = "SELECT n FROM $this->_entityName n Join n.usuario q Where "
                . "q.data_cancelamento Is Null $filter_itens Group By n.usuario Order By q.nome ASC";
        
        return $this->_em->createQuery($stmt);
    }
    
    public function getUsuariosPorNucleoNewsLetter($perfis) {
        
        if(!$perfis){
            return array();
        }
        
        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.usuario CLI Where "
                . " CLI.perfil IN($perfis) And CLI.data_cancelamento Is Null Order By CLI.nome ASC";
        
        return $this->_em->createQuery($stmt)->execute();
    }
    
    public function getNucleoPorUsuario($usuario_id) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.usuario CLI Where "
                . " AT.usuario = $usuario_id And CLI.data_cancelamento Is Null Order By CLI.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
    }
    
    public function getUsuarioPorNucleoUsuario($nucleo_id) {

        $stmt = "SELECT AT FROM $this->_entityName AT Join AT.usuario CLI Where "
                . " AT.nucleo = $nucleo_id And CLI.data_cancelamento Is Null Order By CLI.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
    }

    public function save(\Usuario\Entity\Usuario $usuario, \Projeto\Entity\Nucleo $nucleo) {

        $NucleoUsuario = new Entity();

        $NucleoUsuario->setUsuario($usuario);
        $NucleoUsuario->setNucleo($nucleo);

        $usuario->addNucleoUsuario($NucleoUsuario);

        $this->_em->persist($usuario);
        $this->_em->flush();
    }

    public function removeNucleoUsuario($usuario_id) {
        $this->_em
                ->createQuery("delete from $this->_entityName m where m.usuario = {$usuario_id}")
                ->execute();
    }

}
