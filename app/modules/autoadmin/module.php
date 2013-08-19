<?php

namespace AutoAdmin;

define('AUTOADMINROOT' , __DIR__);

use AutoAdmin\Plugins\Security;
use AutoAdmin\Helpers\EntityManager;
use \Phalcon\DI;
use \Phalcon\Loader;
use \Phalcon\Mvc\View;
use \Phalcon\Assets\Manager as AssetsManager ;

class Module
{

    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
            'AutoAdmin\Controllers' => __DIR__ . '/controllers/' ,
            'AutoAdmin\Models'      => __DIR__ . '/models/' ,
            'AutoAdmin\Plugins'     => __DIR__ . '/plugins/' ,
            'AutoAdmin\Fields'      => __DIR__ . '/fields/' ,
            'AutoAdmin\Helpers'     => __DIR__ . '/helpers/' ,
            'AutoAdmin\Widgets'     => __DIR__ . '/widgets/'
            ]
        );

        $loader->register();
    }

    /**
     * @param \Phalcon\DiInterface $di
     */
    public function registerServices($di)
    {
        $this->registerAutoloaders();

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('dispatch' , new Security($di));

        $di->set(
            'view' ,
            function () use ($di) {
                $view = new View();
                $view->setViewsDir(AUTOADMINROOT . '/views/');

                return $view;
            }
        );

        $di->setShared(
            'entityManager' ,
            function () use ($di) {
                return new EntityManager;
            }
        );

        $di->setShared(
            'assets' ,
            function () {
                return new AssetsManager(
                    [
                    'sourceBasePath' => AUTOADMINROOT . '/assets/' ,
                    'targetBasePath' => PUBLICROOT . '/assets/'
                    ]
                );
            }
        );

    }

}
