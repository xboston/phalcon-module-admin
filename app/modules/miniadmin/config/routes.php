<?php

$miniAdminRouter = new \Phalcon\Mvc\Router\Group(['namespace'  => 'MiniAdmin\Controllers','module'     => 'miniadmin' ,'controller' => 'index' ]);
$miniAdminRouter->setPrefix('/miniadmin');

$miniAdminRouter->add(
    '' ,
    [ 'controller' => 'index' , 'action' => 'index' ]
)->setName('mini-admin-index');

$miniAdminRouter->addGet(
    '/create' ,
    [ 'controller' => 'index' , 'action' => 'create' ]
)->setName('mini-admin-create');

$miniAdminRouter->addPost(
    '/create' ,
    [ 'controller' => 'index' , 'action' => 'create' ]
)->setName('mini-admin-save');

$miniAdminRouter->addGet(
    '/edit/{id:[\d]+}' ,
    [ 'controller' => 'index' , 'action' => 'edit' ]
)->setName('mini-admin-edit');

$miniAdminRouter->addPost(
    '/edit/{id:[\d]+}' ,
    [ 'controller' => 'index' , 'action' => 'edit' ]
)->setName('mini-admin-edit');

return $miniAdminRouter;
