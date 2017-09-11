<?php

namespace Projeto\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class NucleoForm extends Form {

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
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'projeto',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Projeto\Entity\Projeto',
                'property' => 'nome',
                'is_method' => true,
                'label_generator' => function($targetEntity) {
                    return $targetEntity->getNome();
                },
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

        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'coorporativo',
            'attributes' => array(
                'class' => 'form-control',
            ),
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
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'telefone',
            'attributes' => array(
                'class' => 'form-control telefone_mask',
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

        $this->add(array(
            'type' => 'File',
            'name' => 'imagem',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        $this->add(new Element\Csrf('csrf'));
    }

}
