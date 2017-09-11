<?php

namespace Keep\Helper;

use Zend\Authentication\Storage\Session as SessionStorage;

class ControleAcesso {

    public function controleAcesso($objController, $em, $rota) {

        $authService = $objController->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $authService->setStorage(new SessionStorage('admin'));

        if (!$authService->hasIdentity()) {
            header("location:/gestao/login");
            exit;
        }
    }

}
