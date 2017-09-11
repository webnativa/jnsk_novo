<?php

namespace Site\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class ContatoForm extends Form {

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

        parent::__construct('contato-form');

        $this->setAttributes(array(
            'method' => 'POST',
            'class' => 'form-horizontal',
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
                'id' => 'id_nome',
                'placeholder' => 'Nome Completo',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'cidade',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
                'placeholder' => 'Cidade',
            ),
        ));
        
        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
                'id' => 'TxtEmail',
                'placeholder' => 'e-mail',
            ),
        ));
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'telefone',
            'attributes' => array(
                'class' => 'form-control telefone_mask',
                'required' => 'true',
                'id' => 'TxtTelefone',
                'placeholder' => 'Telefone',
            ),
        ));
        
        $this->add(array(
            'type' => 'Textarea',
            'name' => 'mensagem',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
                'placeholder' => 'Escreva a mensagem',
            ),
        ));

        $this->add(new Element\Csrf('csrf'));
    }

}
