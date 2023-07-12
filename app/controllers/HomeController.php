<?php

namespace app\controllers;
use app\models\Connection;

class HomeController
{
    public function index(){
        echo json_encode(['data'=> 'Pagina incial']);
        die;
    }
}
