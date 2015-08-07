<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Dispatcher;
use components\TimeService;
use components\UserService;
use Phalcon\Events\Manager as EventManager;
use listeners\AuthListener;
use listeners\ControllersListener;
use components\AssetManager;
use components\WidgetManager;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * Event manager
 */
$di->set('eventManager', function(){
    return new EventManager();
});

$di->setShared('router', function()use($config){
    return require(APP_PATH . '/app/config/_router_def.php');
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function()use($config){
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->setShared('view', function()use($config){
    return require(APP_PATH . '/app/config/_view_def.php');
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function()use($config){
    return new DbAdapter($config->database->toArray());
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
/*$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});*/

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function(){
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Set the dispatcher
 */
$di->set('dispatcher', function()use($di){
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('controllers');
    $eventsManager = $di->get('eventManager');
    // Set the event manager for dispatcher
    $dispatcher->setEventsManager($eventsManager);
    // Attach the listener
    $eventsManager->attach('dispatch', new ControllersListener($di));
    return $dispatcher;
});

/**
 * Set the timeService
 */
$di->setShared('timeService', function()use($config){
    return new TimeService($config->timeService->toArray());
});

/**
 * Set the User Service
 */
$di->setShared('user', function()use($config, $di){
    $user = new UserService($config->user->toArray());
    $user->setDi($di);
    $eventsManager = $di->get('eventManager');
    // Set the event manager for user service
    $user->setEventsManager($eventsManager);
    // Attach the listener
    $eventsManager->attach('user', new AuthListener());
    return $user;
});

/**
 * Set the Asset manager
 */
$di->setShared('assetManager', function()use($config){
    return new AssetManager($config->assetManager->toArray());
});

// Set the Widget manager
$di->setShared('widget', function()use($config, $di){
    $widgetManager = new WidgetManager($config->widget->toArray());
    $widgetManager->setDi($di);
    return $widgetManager;
});