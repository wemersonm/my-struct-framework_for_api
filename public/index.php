<?php

require 'bootstrap.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');



use app\core\Route;

$route = new Route();
$route->run($router);




