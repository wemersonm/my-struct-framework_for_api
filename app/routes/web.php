<?php

use app\routes\Routers;

$router = new Routers;

/* $router->group(['prefix' => 'admin', 'controller' => 'admin', 'middlewares' => ['auth']], function () {
    $this->add('/', 'GET', 'AdminController@index');
    $this->add('/user/edit/(:numeric)', 'PUT', 'UserController@edit', ['idUser']);
    $this->add('/user/delete/(:numeric)', 'DELETE', 'UserController@edit');
});
 */

$router->add('/', 'GET', 'HomeController@index');
$router->add('/user/(:numeric)', 'GET', 'UserController@show',['idUser'])->middlewares(['auth']);

