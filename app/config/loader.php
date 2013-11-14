<?php

$loader = new \Phalcon\Loader();


$loader->registerNamespaces(
    [
    'Phalcon' => $config->application->libraryDir .'Phalcon',
    ]
);

$loader->registerDirs(
    [
    $config->application->controllersDir ,
    $config->application->modelsDir ,
    $config->application->traitsDir ,
    ]
)->register();
