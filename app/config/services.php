<?php

use Phalcon\DI\FactoryDefault , Phalcon\Mvc\View , Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$di = new FactoryDefault();

$di->set('url', function() use ($config) {
        $url = new Phalcon\Mvc\Url();
        $url->setBaseUri($config->application->baseUri);
        return $url;
    }, true);

$di->set(
    'view' ,
    function () use ($config) {

        $view = new View();
        $view->setViewsDir($config->application->viewsDir);

        return $view;
    } ,
    true
);


$di->set(
    'db' ,
    function () use ($config , $di) {

        return new DbAdapter((array) $config->database);
    }
);

$di->set('config' , $config);

$di->set(
    'router' ,
    function () {

        return require __DIR__ . '/routes.php';
    }
);


