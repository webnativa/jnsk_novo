<?php

namespace Marketing;

return array(
    
    'controllers' => array(
        'invokables' => array(
            'NewsletterController' => 'Marketing\Controller\NewsletterController',
            'BannersController' => 'Marketing\Controller\BannersController',
            
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
            'newsletter' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/newsletter[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NewsletterController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'banners' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/banners[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BannersController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
        ),
    ),
    # definir e gerenciar servicos
    'service_manager' => array(
        'factories' => array(
        #'translator' => 'ZendI18nTranslatorTranslatorServiceFactory',
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
            'clinica/home/index' => __DIR__ . '/../view/newsletter/home/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
);
