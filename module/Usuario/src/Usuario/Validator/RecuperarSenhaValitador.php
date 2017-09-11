<?php

namespace Usuario\Validator;

use Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\InputFilterInterface;

class RecuperarSenhaValitador implements InputFilterAwareInterface {

    protected $inputFilter;
    protected $em;

    function getEm() {
        return $this->em;
    }

    function setEm($em) {
        $this->em = $em;
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
                        'name' => 'DoctrineModule\Validator\ObjectExists',
                        'options' => array(
                            'object_repository' => $this->getEm()->getRepository('Usuario\Entity\Usuario'),
                            'fields' => 'email',
                            'messages' => array(
                                'noObjectFound' => 'e-mail não encontrado'
                            ),
                        ),
                    )
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
