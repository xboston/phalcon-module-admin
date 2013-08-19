<?php

iconv_set_encoding('internal_encoding', 'UTF-8');
setlocale(LC_ALL, 'ru_RU.UTF-8');

define('PUBLICROOT' , __DIR__);
define('COREROOT' , dirname(__DIR__));

(new \Phalcon\Debug())->listen(true , true);

/**
 * Read the configuration
 */
$config = include(__DIR__ . "/../app/config/config.php");

/**
 * Read auto-loader
 */
include __DIR__ . "/../app/config/loader.php";

/**
 * Read services
 */
include __DIR__ . "/../app/config/services.php";


/**
 * Handle the request
 */
$application = new \Phalcon\Mvc\Application($di);

$application->registerModules(require __DIR__ . '/../app/config/modules.php');

echo $application->handle()->getContent();
