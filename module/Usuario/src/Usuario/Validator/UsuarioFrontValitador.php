<?php

namespace Usuario\Validator;

use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

class UsuarioFrontValitador implements InputFilterAwareInterface {

    protected $inputFilter;
    protected $em;
    protected $senha_obrigatoria = true;
    protected $edicao = false;

    function getEm() {
        return $this->em;
    }

    function setEm($em) {
        $this->em = $em;
    }

    function getSenhaObrigatoria() {
        return $this->senha_obrigatoria;
    }

    function setSenhaObrigatoria($edicao) {
        $this->senha_obrigatoria = $edicao;
    }

    function getEdicao() {
        return $this->edicao;
    }

    function setEdicao($edicao) {
        $this->edicao = $edicao;
    }

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
                'name' => 'nascimento',
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
                    
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'format' => 'd/m/Y',
                            'messages' => array(
                                \Zend\Validator\Date::FALSEFORMAT => 'Formato inválido'
                            ),
                        ),
                    ),
                    
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'nome',
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

            $senha_obrigatoria = $this->getSenhaObrigatoria();
            $edicao = $this->getEdicao();

            if ($senha_obrigatoria) {

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
            }

            if (!$edicao) {
                
                
                $inputFilter->add(array(
                    'name' => 'email',
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
                                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.',
                                ),
                            ),
                        ),
                        array(
                            'name' => 'DoctrineModule\Validator\NoObjectExists',
                            'options' => array(
                                'object_repository' => $this->getEm()->getRepository('Usuario\Entity\Usuario'),
                                'fields' => 'email',
                                'messages' => array(
                                    'objectFound' => 'Esse e-mail já está cadastrado'
                                ),
                            ),
                        )
                    ),
                ));
                
                
                
                
                
                $inputFilter->add(array(
                    'name' => 'cpf',
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
                                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.',
                                ),
                            ),
                        ),
                        array(
                            'name' => 'DoctrineModule\Validator\NoObjectExists',
                            'options' => array(
                                'object_repository' => $this->getEm()->getRepository('Usuario\Entity\Usuario'),
                                'fields' => 'cpf',
                                'messages' => array(
                                    'objectFound' => 'CPF ou CNPJ já está cadastrado'
                                ),
                            ),
                        )
                    ),
                ));
    
                
            }

            $inputFilter->add(array(
                'name' => 'telefone',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
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

//            $inputFilter->add(array(
//                'name' => 'cpf',
//                'required' => true,
//                'filters' => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name' => 'NotEmpty',
//                        'options' => array(
//                            'messages' => array(
//                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Campo obrigatório.'
//                            ),
//                        ),
//                    ),
//                ),
//            ));

            $inputFilter->add(array(
                'name' => 'cep',
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
                'name' => 'endereco',
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
                'name' => 'numero',
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
                'name' => 'cidade',
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
                'name' => 'bairro',
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
