<?php

use Phalcon\DI\FactoryDefault , Phalcon\Mvc\View , Phalcon\Mvc\Url as UrlResolver , Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$di = new FactoryDefault();

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


