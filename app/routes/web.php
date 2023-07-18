<?php

use app\routes\Routers;

$router = new Routers;

/* $router->group(['prefix' => 'admin', 'controller' => 'admin', 'middlewares' => []], function () {
    $this->add('/', 'GET', 'AdminController@index');
    $this->add('/user/edit/(:numeric)', 'PUT', 'UserController@edit', ['idUser']);
    $this->add('/user/delete/(:numeric)', 'DELETE', 'UserController@edit');
});
$router->add("/user/(:alpha)/(:numeric)", "DELETE", "UserController@delete");
$router->add('/', 'GET', 'HomeController@index');
$router->add("/user/(:numeric)", "GET", "UserController@show");
$router->add("/user/(:alpha)/(:numeric)", "GET", "UserController@delete");
$router->add("/user", "GET", "UserController@delete");
$router->add('/teste', 'POST', 'HomeController@teste')->middlewares(['auth']); */


$router->add("/login", 'POST','AuthController@login');