<?php

namespace Projeto;

return array(
    'controllers' => array(
        'invokables' => array(
            'ProjetosController' => 'Projeto\Controller\ProjetosController',
            'NucleosController' => 'Projeto\Controller\NucleosController',
            'EquipeController' => 'Projeto\Controller\EquipeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            
            'projetos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/projetos[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ProjetosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'nucleos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/nucleos[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NucleosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'equipe' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/equipe[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'EquipeController',
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
