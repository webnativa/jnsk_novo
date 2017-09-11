<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class LoginForm extends Form {

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

        parent::__construct('login-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'cpf',
            'attributes' => array(
//                'class' => 'form-control',
                'placeholder' => 'e-mail',
            ),
        ));
        
        $this->add(array(
            'type' => 'Password',
            'name' => 'senha',
            'attributes' => array(
//                'class' => 'form-control',
                'placeholder' => 'senha',
            ),
        ));

        $this->add(new Element\Csrf('csrf'));
    }

}
