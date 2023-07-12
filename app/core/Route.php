<?php

namespace app\core;

use app\routes\Routers;
use Exception;

class Route
{
    public function run(Routers $router)
    {
        try {
            $filterRoute = new FilterRoute($router);
            $route = $filterRoute->get();
            $controller = new Controller();
            $controller->execute($route, $filterRoute);
        } catch (Exception $error) {
            echo $error->getMessage();
            die;
        }
    }
}
