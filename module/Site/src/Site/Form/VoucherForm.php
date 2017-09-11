<?php

namespace Site\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VoucherForm extends Form implements ObjectManagerAwareInterface {

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

        parent::__construct('voucher-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));
       
        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'nome',
            ),
        ));

        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'e-mail',
            ),
        ));


        $options_cidade = array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Localizacao\Entity\Cidade',
            'property' => 'nome',
            'disable_inarray_validator' => true,
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array('data_cancelamento' => null),
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
            'empty_option' => '--- Escolha ---'
        );

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'cidade',
            'attributes' => array(
                'class' => 'form-control ajax_cidade',
            ),
            'options' => $options_cidade
        ));

        $options_estado = array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Localizacao\Entity\Uf',
            'property' => 'nome',
            'disable_inarray_validator' => true,
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array(),
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
            'empty_option' => '--- Escolha ---'
        );

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'estado',
            'attributes' => array(
                'class' => 'form-control ajax_uf',
            ),
            'options' => $options_estado
        ));

        $options_regiao = array(
            'object_manager' => $this->getObjectManager(),
            'target_class' => 'Localizacao\Entity\Regiao',
            'property' => 'nome',
            'disable_inarray_validator' => true,
            'is_method' => true,
            'find_method' => array(
                'name' => 'findBy',
                'params' => array(
                    'criteria' => array('data_cancelamento' => null),
                    'orderBy' => array('nome' => 'ASC'),
                ),
            ),
            'empty_option' => '--- Escolha ---'
        );

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'regiao',
            'attributes' => array(
                'class' => 'form-control ajax_regiao',
            ),
            'options' => $options_regiao
        ));
    }

}
