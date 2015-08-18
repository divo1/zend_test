<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ItemRest\Controller\ItemRest' => 'ItemRest\Controller\ItemRestController',
        ),
    ),

    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'item-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/item-rest[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ItemRest\Controller\ItemRest',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
