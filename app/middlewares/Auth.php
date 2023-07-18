<?php

namespace app\middlewares;

use app\helpers\Redirect;
use app\interfaces\MiddlewareInterface;

class Auth implements MiddlewareInterface
{
    public function execute()
    {
        if (!isset($_SESSION['USERLOGGED'])) {
            return Redirect::to("/");
        } 
    
    }
}
