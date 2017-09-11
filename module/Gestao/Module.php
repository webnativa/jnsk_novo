<?php

namespace Gestao;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Login\View\Helper\DadosUser;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module {

    protected $whitelist = array('login',
        'home',
        'cadastro_newsletter',
        'cadastro_usuario',
        'rede-credenciada',
        'voucher',
        'minha-conta',
        'usuarios_front',
        'ajaxbairros',
    );
    protected $dadosAdmin;
    protected $module;

    public function loadConfiguration(MvcEvent $e) {
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        $this->module = $moduleNamespace;

        //set 'variable' into layout...
        $controller->layout()->modulenamespace = $moduleNamespace;
        //echo $this->layout()->modulenamespace;
    }

    public function onBootstrap($e) {

        $app = $e->getApplication();
        $sm = $app->getServiceManager();

        $entityManager = $sm->get('Doctrine\ORM\EntityManager');

        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $auth->setStorage(new SessionStorage('admin'));

        $this->dadosAdmin = $auth->getIdentity();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        
        if ($this->dadosAdmin) {
            
            if(is_null($matchedRoute)){
                return;
            }
            
            $params = $matchedRoute->getParams();
            
            $action = $params['action'];
            $route = $matchedRoute->getMatchedRouteName();

            $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
            $viewModel->current_route = $route;
            
            if (!$request->isPost()) {
                return;
            }

            $paramentrosEnviados = $request->getPost();

            $html = null;
            foreach ($paramentrosEnviados as $key => $value) {
                if (!is_array($key) && !is_array($value)) {
                    if ($key != "csrf" && $key != 'salvar' && $key != "senha" && $key != "confirme_senha") {
                        $html .= "$key : $value <br>";
                    }
                }
            }

        }
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'dadosUser' => function($sm) {

                    $user = null;
                    $em = $sm->getServiceLocator()->get("Doctrine\ORM\EntityManager");

                    if ($this->dadosAdmin) {
                        $user = $em->getRepository("Admin\Entity\Admin")->find($this->dadosAdmin->getId());
                    }

                    return new DadosUser($sm->getServiceLocator()->get('Request'), $user);
                },
            )
        );
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

}
