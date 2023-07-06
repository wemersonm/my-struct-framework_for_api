<?php

namespace app\controllers;

class HomeController
{
    public function index(){
        echo json_encode(['data'=> 'Pagina incial']);
        die;
    }
}
