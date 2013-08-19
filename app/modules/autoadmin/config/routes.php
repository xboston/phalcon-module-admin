<?php

$admin = new \Phalcon\Mvc\Router\Group(['namespace'  => 'Admin\Controllers','module'     => 'admin' ,'controller' => 'admin' ]);

$admin->setPrefix('/admin');

$admin->add(
    '' ,['controller' => 'crud' ,'action'     => 'index']
)->setName('admin');

$admin->add(
    '/{entity:[a-zA-Z]+}/{action:(edit|delete)}/:params' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    //'action'     => 2 ,
    'params'     => 3 ,
    ]
)->setName('admin-action');

// такие действия должны быть только методом POST + проверка токенов
//$admin->addPost(
$admin->addPost(
    '/{entity:[a-zA-Z]+}/{action:(save|delete)}/:params' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    //'action'     => 2 ,
    'params'     => 3 ,
    ]
)->setName('admin-action-post');

$admin->addGet(
    '/{entity}' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    'action'     => 'list' ,
    ]
)->setName('admin-entity');

$admin->add('/login' , [ 'action' => 'login' ])->setName('admin-login');
$admin->add('/logout' , [ 'action' => 'logout' ])->setName('admin-logout');

return $admin;
