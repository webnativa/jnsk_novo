<?php

namespace Usuario\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class UsuarioFrontForm extends Form {

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
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'tipo',
            'options' => array(
                
                'value_options' => array(
                    '1' => ' - Pessoa Física',
                    '0' => ' - Pessoa Jurídica',
                ),
            'attributes' => array(
                 'value' => 1
            )
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'nascimento',
            'attributes' => array(
                'class' => 'form-control date_mask',
                'required' => 'true',
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Email',
            'name' => 'email',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'rg',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'inscricao',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'cpf',
            'attributes' => array(
                'class' => 'form-control cpf_front',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'telefone',
            'attributes' => array(
                'class' => 'form-control telefone_mask',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'senha',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Password',
            'name' => 'confirme_senha',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'cep',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'id_cep',
                'required' => 'true',
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
                'class' => 'form-control ajax_cidade_',
                'required' => 'true',
            ),
            'options' => $options_cidade
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'bairro',
            'attributes' => array(
                'class' => 'form-control combo_bairro',
                'required' => 'true',
            ),
            'options' => array(
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Localizacao\Entity\Bairro',
                'property' => 'nome',
                'is_method' => true,
                'disable_inarray_validator' => true,
                'find_method' => array(
//                    'name' => 'getBairroPorCidade',
                    'name' => 'getBairrosComboCadastroFront',
                ),
                'empty_option' => '--- Escolha ---'
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'endereco',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
                'id' => 'id_endereco',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'numero',
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'true',
            ),
        ));

        $this->add(array(
            'type' => 'Text',
            'name' => 'complemento',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(new Element\Csrf('csrf'));
    }

}
