<?php

/**
 * @todo переписать на класс, наследующий extends Phalcon\Mvc\Router\Group
 */

$autoAdminRouter = new \Phalcon\Mvc\Router\Group([ 'namespace' => 'Admin\Controllers' , 'module' => 'admin' , 'controller' => 'admin' ]);

$autoAdminRouter->setPrefix('/admin');

$autoAdminRouter->add(
    '' ,
    [ 'controller' => 'crud' , 'action' => 'index' ]
)->setName('admin');

$autoAdminRouter->add(
    '/auto/{entity:[a-zA-Z]+}/{action:(edit|delete)}/:params' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    //'action'     => 2 ,
    'params'     => 3 ,
    ]
)->setName('admin-action');

// такие действия должны быть только методом POST + проверка токенов
//$admin->addPost(
$autoAdminRouter->addPost(
    '/auto/{entity:[a-zA-Z]+}/{action:(save|delete)}/:params' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    //'action'     => 2 ,
    'params'     => 3 ,
    ]
)->setName('admin-action-post');

$autoAdminRouter->addGet(
    '/auto/{entity}' ,
    [
    'controller' => 'crud' ,
    'entity'     => 1 ,
    'action'     => 'list' ,
    ]
)->setName('admin-entity');

$autoAdminRouter->add('/login' , [ 'action' => 'login' ])->setName('admin-login');
$autoAdminRouter->add('/logout' , [ 'action' => 'logout' ])->setName('admin-logout');

return $autoAdminRouter;
