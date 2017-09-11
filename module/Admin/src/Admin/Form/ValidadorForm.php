<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class ValidadorForm extends Form {

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

        parent::__construct('validador-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));
        
        $this->add(array(
            'type' => 'Hidden',
            'name' => 'id',
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'gestor',
            'options' => array(
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
            'attributes' => array(
                'value' => 0
            )
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

        $this->add(new Element\Csrf('csrf'));
    }

}
