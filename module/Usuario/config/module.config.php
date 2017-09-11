<?php

namespace Usuario;

return array(
    'controllers' => array(
        'invokables' => array(
            'UsuariosController' => 'Usuario\Controller\UsuariosController',
            'EmpresasController' => 'Usuario\Controller\EmpresasController',
            'PerfisController' => 'Usuario\Controller\PerfisController',
            'DocumentosController' => 'Usuario\Controller\DocumentosController',
            'CategoriasController' => 'Usuario\Controller\CategoriasController',
            'AgendaController' => 'Usuario\Controller\AgendaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'usuarios' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/usuarios[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'UsuariosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'agenda' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/agenda[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AgendaController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'documentos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/documentos[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'DocumentosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            'perfis' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/perfis[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PerfisController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'categorias' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/gestao/categorias[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CategoriasController',
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
            'clinica/home/index' => __DIR__ . '/../view/usuarios/home/index.phtml',
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
