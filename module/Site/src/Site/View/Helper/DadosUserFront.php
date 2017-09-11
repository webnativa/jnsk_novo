<?php

namespace Site\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class DadosUserFront extends AbstractHelper {

    protected $request;
    protected $service_locator;

    public function __construct(Request $request, $getServiceLocator) {
        $this->request = $request;
        $this->service_locator = $getServiceLocator;
    }

    public function __invoke() {

        return $this->service_locator;
    }

}
