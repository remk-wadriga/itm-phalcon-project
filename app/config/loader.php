<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersPath,
        $config->application->modelsPath
    )
)->registerNamespaces([
    'abstracts' => $config->application->abstractsPath,
    'components' => $config->application->componentsPath,
    'controllers' => $config->application->controllersPath,
    'models' => $config->application->modelsPath,
    'interfaces' => $config->application->interfacesPath,
    'forms' => $config->application->formsPath,
    'listeners' => $config->application->listenersPath,
    'assets' => $config->application->assetsPath,
    'widgets' => $config->application->widgetsPath,
])->register();
