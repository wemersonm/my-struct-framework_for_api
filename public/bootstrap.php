<?php

require '../vendor/autoload.php';
require '../app/routes/web.php';

use Dotenv\Dotenv;

$path = dirname(__FILE__, 2);
$dotenv = Dotenv::createMutable($path);
$dotenv->load();
