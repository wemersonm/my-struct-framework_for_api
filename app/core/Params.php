<?php

namespace app\core;

use app\routes\Routers;

class Params
{
    public function get(string $route): string|array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $request = $_SERVER['REQUEST_METHOD'];
        $routes = Routers::get();

        $route = array_search($route, $routes[$request]);
        $arrayUri = explode("/", ltrim($uri,"/"));
        $arrayRoute = explode("/", ltrim($route,"/"));
        $diff = array_diff($arrayUri, $arrayRoute);
       
        return count($diff) > 1 ? array_values($diff) : array_values($diff)[0];

    }
}
