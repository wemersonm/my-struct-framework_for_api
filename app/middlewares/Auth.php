<?php

namespace app\middlewares;

use app\helpers\Redirect;
use app\interfaces\MiddlewareInterface;
use app\supports\JWT;

class Auth implements MiddlewareInterface
{
    public function execute()
    {
        JWT::validateJwt();
    }
}
