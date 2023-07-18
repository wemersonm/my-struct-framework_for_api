<?php

require '../vendor/autoload.php';
require '../app/routes/web.php';
session_start();

use Dotenv\Dotenv;

$path = dirname(__FILE__, 2);
$dotenv = Dotenv::createMutable($path);
$dotenv->load();
