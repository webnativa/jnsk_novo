<?php

namespace Usuario\Validator;

use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

class RedefinirValidator implements InputFilterAwareInterface {

    protected $inputFilter;

    /**
     * Método obrigatório de implementação da interface InputFilterAwareInterface, 
     * não utilizaremos esse método para nada, logo lançamos uma exception em 
     * casa de uso deste
     * 
     * @param ZendInputFilterInputFilterInterface $inputFilter
     * @throws Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception('Não utilizado.');
    }

    /**
     * Método obrigatório de implementação da interface InputFilterAwareInterface,
     * aqui colocamos todas as regras de validações e filtros para nossos campos de
     * input
     * 
     * @return InputFilter
     */
    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'senha',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'confirme_senha',
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'senha',
                            'messages' => array(
                                \Zend\Validator\Identical::NOT_SAME => 'As senha não coincidem'
                            ),
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'confirme_senha',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
                            ),
                        ),
                    ),
                ),
            ));




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
