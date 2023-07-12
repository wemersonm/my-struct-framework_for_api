<?php

namespace app\core;

use app\routes\Routers;

class FilterRoute
{
    private string $uri;
    private string $request;
    private array $routes;

    private array $wildcards = [
        "(:numeric)" => "[0-9]+",
        "(:alpha)" => "[a-z]+",
        "(:any)" => "[a-z0-9\-]+",
    ];

    public function __construct(Routers $routes)
    {

        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
        $this->routes = $this->transformRoutes($routes->get());
    }

    public function exactURL(): ?array
    {
        foreach ($this->routes as $key => &$route) {
            if ($route['request'] == $this->request && $this->uri == $route['uri']) {
                return $route;
            }
        }
        return null;
    }
    public function dynamicURL(): ?array
    {
        foreach ($this->routes as $key => $route) {
            $regex = str_replace("/", "\/", trim($route['uri'], "/"));
            $uri = $this->uri;
            if (preg_match("/^$regex$/", trim($uri, "/"))) {
                return $route;
            }
        }
        return null;
    }
    public function get(): array|string
    {
        return $this->exactURL() ?? ($this->dynamicURL() ?? ['controller' => "NotFoundController@index"]);
    }

    public function getParams(string $route, array $paramAliases): array|string
    {
        $arrayUri = explode("/", ltrim($this->uri, "/"));
        $arrayRoute = explode("/", ltrim($route, "/"));
        $diff = array_diff($arrayUri, $arrayRoute);
        $indexAliases = 0;
        if (!empty($paramAliases)) {
            foreach ($diff as $key => $param) {
                $diff[$paramAliases[$indexAliases]] = $param;
                unset($diff[$key]);
                $indexAliases++;
            }
        }
        return $diff;
    }

    public function transformRoutes(array $routes): array
    {
        foreach ($routes as $key => &$route) {
            foreach ($this->wildcards as $wildcard => $regex) {
                if (str_contains($route['uri'], $wildcard)) {
                    $route['uri'] = str_replace($wildcard, $regex, $route['uri']);
                }
            }
            if (isset($route['options']) && !empty($route['options']) && !empty($route['options']['prefix']) ) {
                $route['uri'] = rtrim("/{$route['options']['prefix']}{$route['uri']}", "/");
            }
        }
        return $routes;
    }
}
