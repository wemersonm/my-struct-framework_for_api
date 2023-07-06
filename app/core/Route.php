<?php

namespace app\core;

use Exception;

class Route
{
    public static function run()
    {
        try {
            $filterRoute = new FilterRoute();
            $route = $filterRoute->get();
            $controller = new Controller();
            $controller->execute($route);
        } catch (Exception $error) {
            echo $error->getMessage();
            die;
        }
    }
}
