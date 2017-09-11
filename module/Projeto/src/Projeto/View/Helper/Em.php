<?php

namespace Clinica\View\Helper;
use Zend\View\Helper\AbstractHelper;


class Em extends AbstractHelper {

    protected $em;

    public function __construct($em) {
        $this->em = $em;
    }

    public function __invoke() {
        return $this->em;
    }

}
