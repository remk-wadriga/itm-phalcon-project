<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 07-08-2015
 * Time: 16:05 PM
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Mvc\Router;

$router = new Router();
$routes = $config->router->routes->toArray();
foreach($routes as $name => $route){
    $key = null;
    $path = null;
    $controller = null;
    $action = null;
    $params = [];

    if(is_array($route)){
        $url = isset($route[0]) ? $route[0] : (isset($route['url']) ? $route['url'] : $name);
        if(isset($route['controller']) && isset($route['action'])){
            $controller = $route['controller'];
            $action = $route['action'];
            if(isset($route['params'])){
                $params = $route['params'];
            }else{
                unset($route['controller']);
                unset($route['action']);
            }
        }elseif(isset($route['path'])){
            $path = $route['path'];
            if(isset($route['params'])){
                $params = $route['params'];
            }else{
                unset($route['path']);
            }
        }elseif(isset($route[1])){
            $path = $route[1];
            if(isset($route['params'])){
                $params = $route['params'];
            }else{
                unset($route[0]);
                unset($route[1]);
            }
        }else{
            $path = $config->application->defaultRoute;
        }
        if(is_string($name)){
            $key = $name;
        }elseif(isset($route['name'])){
            $key = $route['name'];
        }
        unset($route[0], $route['url']);
        if(empty($params) && !empty($route)){
            $params = $route;
        }
    }else{
        $url = $name;
        $path = $route;
    }

    if(!empty($path)){
        $path = explode('/', $path);
        if(isset($path[1])){
            $controller = $path[0];
            $action = $path[1];
        }else{
            $controller = $path[0];
            $action = $config->application->defaultAction;
        }
    }

    if(empty($url)){
        $url = $config->application->baseUri;
    }

    $defArr = [
        'controller' => $controller,
        'action' => $action,
    ];

    $route = $router->add($url, array_merge($defArr, $params));
    if(!empty($key)){
        $route->setName($key);
    }
}

return $router;