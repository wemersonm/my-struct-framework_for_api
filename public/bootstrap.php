<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;

$path = dirname(__FILE__, 2);
$dotenv = Dotenv::createMutable($path);
$dotenv->load();
