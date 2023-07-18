<?php

namespace app\core;

use app\supports\Middleware;
use Exception;

class Controller
{
    public function execute(array $route, FilterRoute $routes)
    {
        list($controller, $method) = explode("@", $route['controller']);

        $controllerWithNamespace = $this->controllerWithNamespace($controller, $route);

        if (!class_exists($controllerWithNamespace)) {
            throw new Exception("O Controller {$controller} não existe !");
        }
        $instanceController = new $controllerWithNamespace();
        if (!method_exists($instanceController, $method)) {
            throw new Exception("O método {$method} não existe !");
        };
        $params = '';
        if (isset($route['uri']) && !empty($route['uri'])) {
            $params = $routes->getParams($route['uri'], $route['paramAliases']);
        }

        if (!empty($route['options']) && isset($route['options']['middlewares'])) {
           
            (new Middleware($route['options']['middlewares']))->execute();
        }


        call_user_func_array([$instanceController, $method], [$params]);
    }

    private function controllerWithNamespace(string $controller, array $route)
    {
        $controllerWithNamespace = "app\\controllers\\" . $controller;
        if (!empty($route['options']) && !empty($route['options']['controller'])) {
            $controllerWithNamespace = "app\\controllers\\" . $route['options']['controller'] . "\\" . $controller;
        }
        return $controllerWithNamespace;
    }
}
