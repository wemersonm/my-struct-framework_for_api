<?php

namespace app\routes;

use Closure;

class Routers
{
    private array $routes = [];
    private array $routeOptions = [];

    public function add(string $uri, string $request, string $controller, array $paramAliases = [])
    {
        $this->routes[] = [
            'uri' => $uri,
            'request' => $request,
            'controller' => $controller,
            'paramAliases' => $paramAliases,
            'options' => $this->routeOptions
        ];
        return $this;
    }
    public function middlewares(array $middlewares)
    {
        $index = count($this->routes) - 1;
        $this->routes[$index]['options']['middlewares'] = $middlewares;
        
    }
    public function group(array $routeOptions, Closure $callback)
    {
        $this->routeOptions = $routeOptions;
        $callback->call($this);
        $this->routeOptions = [];
        return $this;
    }
    public function get(): array
    {
        return $this->routes;
    }
    public function getRouteOptions()
    {
        return $this->routeOptions;
    }
}
