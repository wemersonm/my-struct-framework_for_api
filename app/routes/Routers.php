<?php

namespace app\routes;

class Routers
{
    public static function get(): array
    {
        return [
            'GET' => [
                '/' => 'HomeController@index',
                '/product/[0-9]+' => 'ProductController@show',
                '/user/[a-z]+' => 'UserController@show',
                '/user/[a-z]+/[0-9]+' => "UserController@show"
            ],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [
                '/user/[0-9]+' => "UserController@delete"
            ]
        ];
    }
}
