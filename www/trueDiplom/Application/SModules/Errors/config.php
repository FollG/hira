<?php
return [
    'version' => '1.0.0',
    'name' => 'Errors_MODULE',
    'namespace' => 'Modules\Errors',
    'enabled' => 1,
    'route' => [
        'e404' => [
            'controller' => 'Errors\Controllers\E404',
            'action' => 'main',
            'is_menu' => false,
            'is_auth' => true,
            'method' => 'get',
        ],
        'e403' => [
            'controller' => 'Errors\Controllers\E403',
            'action' => 'main',
            'is_menu' => false,
            'is_auth' => true,
            'method' => 'get',
        ],
        'NoSupport' => [
            'controller' => 'Errors\Controllers\NoSupport',
            'action' => 'main',
            'is_menu' => false,
            'is_auth' => false,
            'method' => 'get',
        ],
    ],
    'init_php' => [
        __DIR__ . '/index.php',
    ],
];