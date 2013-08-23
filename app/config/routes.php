<?php

$router = new Phalcon\Mvc\Router(false);

$router->notFound(array( "controller" => "index" , "action" => "error404" ));

$router->add('/' , 'Index::index')->setName('main');

$router->add('/realty/{type:.*}' , 'Realty::index')->setName('realty');
$router->add('/realty/{type:.*}/{slug:.*}' , 'Realty::show')->setName('realty-show');

$router->add('/leisure/{type:.*}' , 'Leisure::index')->setName('leisure');
$router->add('/leisure/{type:.*}/{slug:.*}' , 'Leisure::show')->setName('leisure-show');

$router->add('/transports/{type:(autos|yachts)}/{id:[\d]+}' , 'Transports::show')->setName('transports-show');
$router->add('/transports/{type:(autos|yachts)}' , 'Transports::index')->setName('transports');

$router->add('/services/{slug:.*}' , 'Services::show')->setName('services-show');
$router->add('/services/{type:(traveling|investors)}' , 'Services::index')->setName('services');

$router->add('/events/{slug:.*}' , 'Events::show')->setName('events-show');
$router->add('/events' , 'Events::index')->setName('events');
$router->add('/events/{date_from:\d\d\d\d-\d\d\-\d\d}' , 'Events::index')->setName('events-date');
$router->add('/events/{date_from:\d\d\d\d-\d\d\-\d\d}-{date_to:\d\d\d\d-\d\d\-\d\d}' , 'Events::index')->setName('events-date-range');
$router->add('/events/{date_from:\d\d\d\d-\d\d\-\d\d}-{date_to:\d\d\d\d-\d\d\-\d\d}/{categories:.+}' , 'Events::index')->setName('events-categories');

$router->add('/cart' , 'Cart::index')->setName('cart');
$router->add('/cart/add' , 'Cart::add')->setName('cart-add');
$router->add('/cart/confirm' , 'Cart::confirm')->setName('cart-confirm');


$router->mount(require_once COREROOT . '/app/modules/autoadmin/config/routes.php');
$router->mount(require_once COREROOT . '/app/modules/admin/config/routes.php');

return $router;
