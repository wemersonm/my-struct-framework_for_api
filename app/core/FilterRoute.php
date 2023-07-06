<?php

namespace app\core;

use app\routes\Routers;

class FilterRoute
{
    private string $uri;
    private string $request;
    private array $routes;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->routes = Routers::get();
    }

    public function exactURL(): string|null
    {
        if (array_key_exists($this->uri, $this->routes[$this->request])) {
            return $this->routes[$this->request][$this->uri];
        }
        return null;
    }
    public function dynamicURL(): string|null
    {
        foreach ($this->routes[$this->request] as $route => $value) {
            $regex = str_replace("/", "\/", $route);
            if (preg_match("/^$regex$/", $this->uri)) {
                return $value;
            }
        }
        return null;
    }
    public function get(): string
    {
        return $this->exactURL() ?? ($this->dynamicURL() ?? "NotFoundController@index");
    }
}
