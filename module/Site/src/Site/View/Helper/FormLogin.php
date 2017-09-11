<?php

namespace Site\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;
use Usuario\Form\LoginForm;

class FormLogin extends AbstractHelper {

    protected $em;

    public function __construct($em) {
        $this->em = $em;
    }

    public function __invoke() {
        $form = new LoginForm($this->em);
        return $form;
    }

}
