<?php

namespace Admin;

define('ADMINROOT' , __DIR__);

use Phalcon\DI;
use Phalcon\Loader;

class Module
{

    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
            'Admin\Controllers' => ADMINROOT . '/controllers/' ,
            'Admin\Fields'      => ADMINROOT . '/fields/'
            ]
        );

        $loader->registerClasses(
            [
            'AutoAdmin\Module' => ADMINROOT . '/../autoadmin/module.php'
            ]
        );

        $loader->register();
    }

    /**
     * @param DI $di
     */
    public function registerServices($di)
    {
        $auto_admin = new \AutoAdmin\Module();
        $auto_admin->registerServices($di);

        $di->set(
            'admin_views_dir' ,
            function () {
                return ADMINROOT . '/views/';
            }
        );

        $di->set(
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
