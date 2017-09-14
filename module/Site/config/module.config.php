<?php


return array(
    'controllers' => [
        'invokables' => [
            'Site\Controller\IndexController' => 'Site\Controller\IndexController',
            'Site\Controller\UsuariosController' => 'Site\Controller\UsuariosController',
            'Site\Controller\ContatoController' => 'Site\Controller\ContatoController',
            'Site\Controller\EstaticasController' => 'Site\Controller\EstaticasController',
            'Site\Controller\NoticiasController' => 'Site\Controller\NoticiasController',
            'Site\Controller\InstitucionalController' => 'Site\Controller\InstitucionalController',
            'Site\Controller\CcgcController' => 'Site\Controller\CcgcController',
            'Site\Controller\ConsorciadasController' => 'Site\Controller\ConsorciadasController',
            'Site\Controller\DepoimentosController' => 'Site\Controller\DepoimentosController',
            'Site\Controller\VideosController' => 'Site\Controller\VideosController',
            'Site\Controller\EquipeController' => 'Site\Controller\EquipeController',
            'Site\Controller\EventosController' => 'Site\Controller\EventosController',
            'Site\Controller\trintaAnosController' => 'Site\Controller\trintaAnosController',
            'Site\Controller\proRegularController' => 'Site\Controller\proRegularController',
            'Site\Controller\proEscolasController' => 'Site\Controller\proEscolasController',
            'Site\Controller\historiaController' => 'Site\Controller\historiaController',
        ]
    ],
    'router' => array(
        'routes' => array(
            'ccgc' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/ccgc[/:action][/:slug]',
                    'constraints' => array(
                        'slug' => '[a-zA-Z][a-zA-Z0-9_\/-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\CcgcController',
                        'action' => 'index',
                        'slug' => 'home'
                    ),
                ),
            ),
            'contato' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/contato[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\ContatoController',
                        'action' => 'index',
                    ),
                ),
            ),
            'institucional_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/instituicao[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\InstitucionalController',
                        'action' => 'index',
                    ),
                ),
            ),
           

            'consorciadas_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/cooperativas[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\ConsorciadasController',
                        'action' => 'index',
                    ),
                ),
            ),


            'noticias_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/noticias[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\NoticiasController',
                        'action' => 'index',
                    ),
                ),
            ),

            'eventos_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/eventos[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\EventosController',
                        'action' => 'index',
                    ),
                ),
            ),

            'depoimentos_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/depoimentos[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\DepoimentosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'videos_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/videos[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\VideosController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'estaticas_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/institucional[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\EstaticasController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
             'equipe_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/central-de-compras[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\EquipeController',
                        'action' => 'index',
                    ),
                ),
            ),
            
            
            
            'usuarios_front' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/usuarios[/:action][/:id]/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\UsuariosController',
                        'action' => 'index',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Site\Controller\IndexController',
                        'action' => 'index',
                    ),
                ),
            ),

            'trintaAnos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/trintaAnos',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\trintaAnosController',
                        'action' => 'index',
                    ),
                ),
            ),

            'proRegular' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/excursoes-jonosake',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\proRegularController',
                        'action' => 'index',
                    ),
                ),
            ),

            'proEscolas' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/excursoes-escolares-jonosake',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\proEscolasController',
                        'action' => 'index',
                    ),
                ),
            ),

            'historia' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/historia-jonosake',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Site\Controller\historiaController',
                        'action' => 'index',
                    ),
                ),
            ),





        )
    ),
    
    'service_manager' => array(
        'factories' => array(
            'KeepMail' => function ($sm) {
                $keepMail = new \Keep\Helper\Email();
                return $keepMail;
            },
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'menu' => __DIR__ . '/../view/layout/menu.phtml',
            'footer' => __DIR__ . '/../view/layout/footer.phtml',
            'error/404' => __DIR__ . '/../view/layout/error/404.phtml',
            'error/index' => __DIR__ . '/../view/layout/error/index.phtml',
        ),
    ),
);
