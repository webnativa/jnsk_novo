<?php

namespace Site;

use Site\View\Helper\FormLogin;
use Site\View\Helper\DadosUserFront;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
    
    protected $dadosUserFront;

    public function onBootstrap($e) {

        $app = $e->getApplication();
        $sm = $app->getServiceManager();

        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $auth->setStorage(new SessionStorage('front'));

        $this->dadosUserFront = $auth->getIdentity();
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
                'dadosUserFront' => function($sm) {

                    $em = $sm->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                    
                    $user = null;
                    if($this->dadosUserFront){
                        $user = $em->getRepository("Usuario\Entity\Usuario")->find($this->dadosUserFront->getId());
                    }
                    
                    return new DadosUserFront($sm->getServiceLocator()->get('Request'), $user);
                },
                'FormLogin' => function($sm) {
                    $em = $sm->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                    return new FormLogin($em);
                }
            )
        );
    }

}
