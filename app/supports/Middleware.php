<?php

namespace app\supports;

use app\enums\RouteMiddlewares;
use Exception;

class Middleware
{
    private string $middlewareClass;

    public function __construct(public array $middlewares)
    {
    }

    private function middlewareExist(string $middleware)
    {

        $middlewareCases = RouteMiddlewares::cases(); // enum
        return array_filter($middlewareCases, function (RouteMiddlewares $middlewareCase) use ($middleware) {

            if ($middlewareCase->name == $middleware) {
                $this->middlewareClass = $middlewareCase->value;
                return true;
            } else {
                return false;
            }
        });
    }
    public function execute()
    {
        foreach ($this->middlewares as $middleware) {
            if (!$this->middlewareExist($middleware)) {
                throw new Exception("Middleware {$middleware} não existe");
            }

            $class = $this->middlewareClass;
            if (!class_exists($class)) {
                throw new Exception("Class middleware {$middleware} não existe");
            }

            $intanceMiddleware = new $class;
            $intanceMiddleware->execute();
        }
    }
}
