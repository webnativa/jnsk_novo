<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class UsuarioForm extends Form {

    protected $objectManager;

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
        return $this;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    public function __construct(ObjectManager $objectManager) {

        $this->setObjectManager($objectManager);

        parent::__construct('usuario-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'id',
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'cooperativa',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Cooperativa\Entity\Cooperativa',
                'property' => 'nome',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('data_cancelamento' => null),
                        'orderBy' => array('nome' => 'ASC'),
                    ),
                ),
                'empty_option' => '--- Nenhuma ---'
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'perfil',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Usuario\Entity\Perfil',
                'property' => 'nome',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('data_cancelamento' => null),
                        'orderBy' => array('nome' => 'ASC'),
                    ),
                ),
                'empty_option' => '--- Escolha ---'
            ),
        ));


//        $this->add(array(
//            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
//            'name' => 'nucleo',
//            'options' => array(
//                'object_manager' => $this->getObjectManager(),
//                'target_class' => 'Projeto\Entity\Nucleo',
//                'property' => 'nome',
//                'is_method' => true,
//                'label_generator' => function($targetEntity) {
//                    return ' - ' . $targetEntity->getNome();
//                },
//                'find_method' => array(
//                    'name' => 'findBy',
//                    'params' => array(
//                        'criteria' => array('data_cancelamento' => null),
//                        'orderBy' => array('nome' => 'ASC'),
//                    ),
//                ),
//                'option_attributes' => array(
//                    'id' => function (\Projeto\Entity\Nucleo $entity) {
//                        return 'nucleo_' . $entity->getId();
//                    }
//                ),
//                'empty_option' => '--- Escolha ---'
//            ),
//        ));

        $this->add(new Element\Csrf('csrf'));
    }

}
