<?php

namespace app\controllers;

use app\models\Filters;
use app\models\QueryBuilder;
use app\supports\JWT;
use app\supports\Request;
use app\traits\Validations;

class HomeController
{
    public function index()
    {
        
        echo json_encode(['data' => 'Pagina incial']);
    }
}
