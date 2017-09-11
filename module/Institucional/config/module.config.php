<?php

namespace Institucional;

return array(
    'controllers' => array(
        'invokables' => array(
            'BlocoHomeController' => 'Institucional\Controller\BlocoHomeController',
            'InstituicaoController' => 'Institucional\Controller\InstituicaoController',
            'NoticiasController' => 'Institucional\Controller\NoticiasController',
            'DepoimentosController' => 'Institucional\Controller\DepoimentosController',
            'VideosController' => 'Institucional\Controller\VideosController',
        ),
    ),
    'router' => array(
        'routes' => array(
            
            'bloco-home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/bloco-home[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'BlocoHomeController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'instituicao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/instituicao[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'InstituicaoController',
                        'action' => 'index',
                    ),
                ),
            ),

            'noticias' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/noticias[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NoticiasController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'depoimentos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/depoimentos[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'DepoimentosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'videos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/videos[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'VideosController',
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
    # definir e gerenciar layouts, erros, exceptions, doctype base
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'clinica/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'clinica/home/index' => __DIR__ . '/../view/clinica/home/index.phtml',
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
