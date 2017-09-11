<?php

namespace Admin;
use Institucional\View\Helper\MenuAtivo;
use Institucional\View\Helper\Message;

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
                    return new Message($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
                },
                'menuAtivo' => function($sm) {
                    return new MenuAtivo($sm->getServiceLocator()->get('Request'));
                },
            )
        );
    }

}