<?php

return array(
    'controllers' => [
        'invokables' => [
            'Gestao\Controller\Index' => 'Gestao\Controller\IndexController'
        ]
    ],
    
    
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/[/:action][/:id]',
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
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);