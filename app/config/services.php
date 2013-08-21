<?php

use Phalcon\DI\FactoryDefault , Phalcon\Mvc\View , Phalcon\Mvc\Url as UrlResolver , Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

DEFINE('PH_DEBUG' , (isset($_SERVER['PHDEBUG']) || isset($_COOKIE['PHDEBUG'])));


$di = new FactoryDefault();


$di->set(
    'url' ,
    function () use ($config) {
        $url = new UrlResolver();
        $url->setBaseUri($config->application->baseUri);

        return $url;


    } ,
    true
);


$di->set(
    'view' ,
    function () use ($config) {

        $view = new View();

        $view->setViewsDir($config->application->viewsDir);

        $view->registerEngines(
            array(
                 '.phtml' => 'Phalcon\Mvc\View\Engine\Php' // Generate Template files uses PHP itself as the template engine
            )
        );

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


