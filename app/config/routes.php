<?php

$router = new Phalcon\Mvc\Router(false);
$router->removeExtraSlashes(true);

$router->notFound(array( "controller" => "index" , "action" => "error404" ));

$router->add('/' , 'Index::index')->setName('main');

$router->mount(require_once COREROOT . '/app/modules/miniadmin/config/routes.php');

$router->mount(require_once COREROOT . '/app/modules/autoadmin/config/routes.php');
$router->mount(require_once COREROOT . '/app/modules/admin/config/routes.php');

return $router;
