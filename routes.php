<?php

$rotas = [
    '/'              => ['controller' => 'HomeController',  'method' => 'index',  'menuLabel' => 'Home',         'showInMenu' => true],
    '/colors'        => ['controller' => 'ColorController', 'method' => 'index',  'menuLabel' => 'Colors',       'showInMenu' => true],
    '/colors/edit'   => ['controller' => 'ColorController', 'method' => 'edit',   'menuLabel' => 'Color Edit',   'showInMenu' => false],
    '/colors/add'    => ['controller' => 'ColorController', 'method' => 'add',    'menuLabel' => 'Color Add',    'showInMenu' => false],
    '/colors/new'    => ['controller' => 'ColorController', 'method' => 'new',    'menuLabel' => 'Color New',    'showInMenu' => false],
    '/colors/update' => ['controller' => 'ColorController', 'method' => 'update', 'menuLabel' => 'Color Update', 'showInMenu' => false],
    '/colors/delete' => ['controller' => 'ColorController', 'method' => 'delete', 'menuLabel' => 'Color Delete', 'showInMenu' => false],
    '/users'         => ['controller' => 'UserController',  'method' => 'index',  'menuLabel' => 'Users',        'showInMenu' => true],
    '/users/edit'    => ['controller' => 'UserController',  'method' => 'edit',   'menuLabel' => 'User Edit',    'showInMenu' => false],
    '/users/add'     => ['controller' => 'UserController',  'method' => 'add',    'menuLabel' => 'User Add',     'showInMenu' => false],
    '/users/new'     => ['controller' => 'UserController',  'method' => 'new',    'menuLabel' => 'User New',     'showInMenu' => false],
    '/users/update'  => ['controller' => 'UserController',  'method' => 'update', 'menuLabel' => 'User Update',  'showInMenu' => false],
    '/users/delete'  => ['controller' => 'UserController',  'method' => 'delete', 'menuLabel' => 'User Delete',  'showInMenu' => false],
];

return $rotas;