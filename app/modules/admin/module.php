<?php

namespace Admin;

define('ADMINROOT' , __DIR__);

use \Phalcon\DI;
use \Phalcon\Loader;
use \Phalcon\Mvc\ModuleDefinitionInterface;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Session\Adapter\Files as Session;
use \AutoAdmin\Plugins\AdminSecurity;

class Module implements ModuleDefinitionInterface
{

    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
            'Admin\Controllers' => ADMINROOT . '/controllers/' ,
            'Admin\Fields'      => ADMINROOT . '/fields/'
            ] ,
            true
        );

        $loader->registerClasses(
            [
            'AutoAdmin\Module' => ADMINROOT . '/../autoadmin/module.php'
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

        //Registering a dispatcher
        $di->setShared(
            'dispatcher' ,
            function () use ($di) {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Admin");

                $eventsManager = $di->getShared('eventsManager');

                $eventsManager->attach('dispatch' , new AdminSecurity($di));

                $dispatcher->setEventsManager($eventsManager);

                return $dispatcher;
            }
        );


        $auto_admin = new \AutoAdmin\Module();
        $auto_admin->registerServices($di);

        $di->setShared(
            'admin_views_dir' ,
            function () {
                return ADMINROOT . '/views/';
            }
        );

        $di->setShared(
            'session' ,
            function () {

                $session = new Session();
                $session->start();

                return $session;
            }
        );

        $di->setShared(
            'config' ,
            function () use ($di) {

                $configFront = require COREROOT . '/app/config/config.php';
                $configBack  = require ADMINROOT . '/config/config.php';

                $configFront->merge($configBack);

                return $configFront;
            }
        );

    }

}
