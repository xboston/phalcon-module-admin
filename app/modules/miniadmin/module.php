<?php

namespace MiniAdmin;

define('MINI_ADMIN_ROOT' , __DIR__);

use \Phalcon\DI;
use \Phalcon\Loader;
use \Phalcon\Mvc\ModuleDefinitionInterface;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{

    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
            'MiniAdmin\Controllers' => MINI_ADMIN_ROOT . '/controllers/' ,
            'MiniAdmin\Helpers'     => MINI_ADMIN_ROOT . '/helpers/' ,
            ] ,
            true
        );

        $loader->register();
    }

    /**
     * @param DI $di
     */
    public function registerServices($di)
    {
        $this->registerAutoloaders();

        $di->setShared(
            'session' ,
            function () {

                $session = new \Phalcon\Session\Adapter\Files();
                $session->start();

                return $session;
            }
        );

        $di->set(
            'view' ,
            function () use ($di) {

                $view = new View();
                $view->setViewsDir(MINI_ADMIN_ROOT . '/views/');

                return $view;
            }
        );
    }
}
