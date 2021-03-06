<?php

namespace Projeto\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class ProjetoForm extends Form {

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
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'status',
            'options' => array(
                'checked_value' => 1,
                'unchecked_value' => 0
            ),
            'attributes' => array(
                'value' => 1
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
            'type' => 'Text',
            'name' => 'cor',
            'attributes' => array(
                'class' => 'form-control colorp colorpicker-element',
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

        $this->add(array(
            'type' => 'Textarea',
            'name' => 'descricao',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Number',
            'name' => 'posicao',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        $this->add(new Element\Csrf('csrf'));
    }

}
