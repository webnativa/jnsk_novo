<?php

namespace Institucional\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class MenuAtivo extends AbstractHelper {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function __invoke(array $urls) {
        
        $currentUrl = $this->request->getUri()->getPath();
        $currentUrl = explode('/', $currentUrl)[2];
        
        if (in_array("/gestao/$currentUrl", $urls)) {
            return 'active';
        }
        return null;
    }

}
