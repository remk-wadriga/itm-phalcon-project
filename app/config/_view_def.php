<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 07-08-2015
 * Time: 16:10 PM
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

$view = new View();
$view->setViewsDir($config->application->viewsDir);
$view->setVars($config->view->vars->toArray());

$view->registerEngines([
    '.volt' => function($view, $di)use($config){
        $volt = new VoltEngine($view, $di);
        $volt->setOptions($config->volt->options->toArray());

        $functions = $config->volt->functions->toArray();
        foreach($functions as $name => $function){
            $volt->getCompiler()->addFunction($name, function($params)use($function) {
                if(is_array($function)){
                    $funcArray = $function;
                    $function = $funcArray['function'];
                    if(isset($funcArray['params']) && !empty($funcArray['params'])){
                        if(!is_array($params)){
                            $params = (array)$params;
                        }
                        $params = array_merge($params, $funcArray['params']);
                        $params = serialize(array_filter($params));
                        return "$function(unserialize('{$params}'))";
                    }
                }

                if(strpos($function, '{params}') !== false){
                    return str_replace('{params}', $params, $function);
                }else{
                    return "{$function}({$params})";
                }
            });
        }

        return $volt;
    },
    '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
]);

return $view;