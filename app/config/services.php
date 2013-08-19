<?php

use Phalcon\DI\FactoryDefault,
	Phalcon\Mvc\View,
	Phalcon\Mvc\Url as UrlResolver,
	Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	Phalcon\Session\Adapter\Files as SessionAdapter;

DEFINE('PH_DEBUG' , (isset($_SERVER['PHDEBUG']) || isset($_COOKIE['PHDEBUG'])));


/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * We register the events manager
 */
$di->set('dispatcher', function() use ($di) {
        /** @var \Phalcon\Events\Manager $eventsManager */
        $eventsManager = $di->getShared('eventsManager');

        $secure   = new Security($di);
        //todo включить плагин
//        $eventsManager->attach('dispatch', $secure);

        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($config) {
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);
	return $url;


}, true);

/**
 * Setting up the view component
 */
$di->set('view', function() use ($config) {

	$view = new View();

	$view->setViewsDir($config->application->viewsDir);

	$view->registerEngines(array(
		'.phtml' => 'Phalcon\Mvc\View\Engine\Php' // Generate Template files uses PHP itself as the template engine
	));

	return $view;
}, true);

PH_DEBUG ? $di->set(
    'dbprofiler',
    function () {
        return new Phalcon\Db\Profiler();
    }
) : null;

$di->set('modelsManager', function () use ($di) {
    /** @var \Phalcon\Events\Manager $eventsManager */
    $eventsManager = $di->getShared('eventsManager');
    $eventsManager->attach('model', new SetCreatedAt());

    $modelsManager = new \Phalcon\Mvc\Model\Manager();
    $modelsManager->setEventsManager($eventsManager);

    return $modelsManager;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function() use ($config, $di) {
	$db = new DbAdapter( (array) $config->database );

    if (PH_DEBUG) {
        $eventsManager = new Phalcon\Events\Manager();
        $profiler      = $di->getShared('dbprofiler');
        $eventsManager->attach(
            'db',
            function ($event, $connection) use ($profiler) {
                /** @var \Phalcon\Events\Event $event */
                /** @var \Phalcon\Db\Adapter\Pdo\Mysql $connection */
                /** @var Phalcon\Db\Profiler $profiler */
                if ($event->getType() == 'beforeQuery') {
                    $profiler->startProfile($connection->getSQLStatement());
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            }
        );

        $db->setEventsManager($eventsManager);
    }

    return $db;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function() use ($config) {
    if (isset($config->models->metadata)) {
        $metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\' . $config->models->metadata->adapter;
        return new $metadataAdapter();
    }

	return new \Phalcon\Mvc\Model\Metadata\Memory();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

$di->set('config', $config);

$di->set('router', function () {
    return require __DIR__ . '/routes.php';
});

$di->set(
    'seo',
    function () {
        return new Seo();
    }
);

$di->set(
    'solr',
    function () use ($config) {
        return Solr::instance($config->solr);
    }
);

$di->set(
    'search',
    function () {
        return new Search();
    }
);

$di->set('cache', function() use ($config) {
    //Cache data for one day by default
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => $config->memcache->lifetime
    ));

    //Memcached connection settings
    $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
        "host" => $config->memcache->host,
        "port" => $config->memcache->port
    ));

    return $cache;
});

$di->set(
    'config_images',
    function () {
        $config = require __DIR__.'/images.php';
        return $config;
    }
);

