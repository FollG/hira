<?php
return [
    'version' => '1.0.0',
    'name' => 'Tasks_MODULE',
    'namespace' => 'Tasks',
    'enabled' => 1,
    'route' => [
        'tasks' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'main',
            'name' => 'Tasks',
            'order' => 200,
            'parent_module' => null,
            'is_menu' => true,
            'active' => true,
            'is_auth' => true,
            'method' => 'get',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M5 17.5V15.8333C5 14.9493 5.35119 14.1014 5.97631 13.4763C6.60143 12.8512 7.44928 12.5 8.33333 12.5H11.6667C12.5507 12.5 13.3986 12.8512 14.0237 13.4763C14.6488 14.1014 15 14.9493 15 15.8333V17.5M6.66667 5.83333C6.66667 6.71739 7.01786 7.56523 7.64298 8.19036C8.2681 8.81548 9.11594 9.16667 10 9.16667C10.8841 9.16667 11.7319 8.81548 12.357 8.19036C12.9821 7.56523 13.3333 6.71739 13.3333 5.83333C13.3333 4.94928 12.9821 4.10143 12.357 3.47631C11.7319 2.85119 10.8841 2.5 10 2.5C9.11594 2.5 8.2681 2.85119 7.64298 3.47631C7.01786 4.10143 6.66667 4.94928 6.66667 5.83333Z" stroke="#8A8B99" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ],
        'task' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'show',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/get' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_get',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/sendcomment' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_sendcomment',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/checkonuser' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_checkonuser',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/changeurgency' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_changeUrgency',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/changeStatus' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_changeStatus',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
        'tasks/post/setTimeTracker' => [
            'controller' => 'Tasks\Controllers\Tasks',
            'action' => 'post_setTimeTracker',
            'name' => 'Tasks',
            'method' => 'POST',
        ],
    ],
    'privileges' => [
        'CorporatePortal' => ['name' => 'Корпоративный портал', 'parent' => null, 'values' => [1 => 'Да',0 => 'Нет'], 'default' => 1],
    ],
    'init_php' => [
        __DIR__ . '/index.php',
    ]
];