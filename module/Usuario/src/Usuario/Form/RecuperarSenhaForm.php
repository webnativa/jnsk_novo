<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class RecuperarSenhaForm extends Form {

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

        parent::__construct('recuperar-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));

        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));
        
        $this->add(new Element\Csrf('csrf'));
    }

}
