<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

class Auth implements MiddlewareInterface
{
    public function execute()
    {
        echo "Middleware Auth \n";
    }

}
