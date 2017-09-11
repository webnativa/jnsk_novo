<?php

namespace Marketing\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BannerForm extends Form implements ObjectManagerAwareInterface {

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

        parent::__construct('banner-form');

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
            'type' => 'Text',
            'name' => 'link',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        
        $this->add(array(
            'type' => 'File',
            'name' => 'arquivo',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(new Element\Csrf('csrf'));
    }

}
