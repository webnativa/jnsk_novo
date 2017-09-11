<?php

namespace Admin;

use \Admin\Entity\Admin as AdminUser;

return array(
    'controllers' => array(
        'invokables' => array(
            'LoginController' => 'Login\Controller\LoginController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/login[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'LoginController',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
     
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'clinica/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'clinica/home/index' => __DIR__ . '/../view/usuarios/home/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Admin\Entity\Admin',
                'identity_property' => 'email',
                'credential_property' => 'senha',
                'credential_callable' => function(\Admin\Entity\Admin $user, $passwordGiven) {
                    return (new AdminUser())->hashPassword($user, $passwordGiven);
                },
            ),
        ),
        
    ),
);
