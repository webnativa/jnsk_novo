<?php

namespace Projeto;

use Localizacao\View\Helper\MenuAtivo;
use Institucional\View\Helper\Em;

class Module {
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Keep' => __DIR__ . '/../../vendor/keep/library/Keep',
                ),
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'message' => function($sm) {
                    return new View\Helper\Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
                },
                'menuAtivo' => function($sm) {
                    return new MenuAtivo($sm->getServiceLocator()->get('Request'));
                },
                'getEm' => function($sm) {
                    $em = $sm->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                    return new Em($em);
                },
            )
        );
    }

}