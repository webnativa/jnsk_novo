<?php

namespace Institucional\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class DepoimentoForm extends Form {

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

        parent::__construct('clinica-form');

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
            'type' => 'File',
            'name' => 'imagem',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Textarea',
            'name' => 'texto',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'editor1',
            ),
        ));
        
        $this->add(new Element\Csrf('csrf'));
    }

}
