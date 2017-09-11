<?php

namespace Usuario\Repository;

use Doctrine\ORM\EntityRepository;
use Usuario\Entity\Usuario as Entity;

class Usuario extends EntityRepository {
    
    public function getUsuarioPorPerfil($perfis) {
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.perfil IN($perfis) ORDER BY q.nome ASC";
        
        return $this->_em->createQuery($stmt)->execute();
    }
    
    public function getAll($filters) {
        
        $filter_itens = \Keep\Helper\Filter::configure($filters);
        
        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL $filter_itens ORDER BY q.nome ASC";
        
        return $this->_em->createQuery($stmt);
    }

    public function autoComplete($nome = null) {

        $stmt = "SELECT q FROM $this->_entityName q Where "
                . "q.data_cancelamento IS NULL And q.nome Like '%{$nome}%' ORDER BY q.nome ASC";

        return $this->_em->createQuery($stmt)->getResult();
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
        
        if($data['cooperativa']){
            
            $cooperativa = $this->_em->getReference('\Cooperativa\Entity\Cooperativa', $data['cooperativa']);
            $entity->setCooperativa($cooperativa);
        }else{
            
            $entity->setCooperativa(null);
        }
        
        $perfil = $this->_em->getReference('\Usuario\Entity\Perfil', $data['perfil']);
        $entity->setPerfil($perfil);
        
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    public function cadastroFront(array $data) {

        $entity = new Entity();

        $entity = \Keep\Helper\Configurator::configure($entity, $data);

        $bairro = $this->_em->getReference('\Localizacao\Entity\Bairro', $data['bairro']);
        $entity->setBairro($bairro);
        
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }
    
    public function updateFront(array $data) {
        
        unset($data['senha']);
        
        $entity = $this->_em->find("{$this->_entityName}", (int) $data['id']);

        $entity = \Keep\Helper\Configurator::configure($entity, $data);

        $bairro = $this->_em->getReference('\Localizacao\Entity\Bairro', $data['bairro']);
        $entity->setBairro($bairro);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

}
