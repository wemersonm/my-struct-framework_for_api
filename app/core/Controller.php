<?php

namespace app\core;

use Exception;

class Controller
{
    public function execute(string $route)
    {
        list($controller, $method) = explode("@", $route);

        $path = dirname(__FILE__, 2);
        if (!file_exists($path . "/controllers/" . $controller . ".php")) {
            throw new Exception("O Controller {$controller} não existe !");
        }
        $controllerWithNamespace = "app\\controllers\\" . $controller;
        $instanceController = new $controllerWithNamespace();
        if (!method_exists($instanceController, $method)) {
            throw new Exception("O método {$method} não existe !");
        }
        $getParams = new Params();
        $params = '';
        if (!empty($params)) {
            $params = $getParams->get($route);
        }
        $instanceController->$method($params);
    }
}
