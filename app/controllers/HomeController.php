<?php

namespace app\controllers;

use app\models\Filters;
use app\models\QueryBuilder;
use app\supports\Request;
use app\traits\Validations;

class HomeController
{
    public function index()
    {

        // $filter = new Filters;
        // $user  = new QueryBuilder();
        // $validations = new Validations;

        // var_dump($validations->validations([
        //     'name_user' => 'required',
        //     'email_user' => 'required'

        // ]));

        // $filter->join("admins", "users.id_user", "=", "admins.id_user", "LEFT JOIN")->where("users.id_user", ">", 1533, "AND")->in("users.age", [15, 16, 17, 18])->orderBy("users.id", "DESC")->limit("20")->get();

        // var_dump($filter->getQuery());

        echo json_encode(['data'=> 'Pagina incial']);
    }
    public function teste()
    {
        echo json_encode(['data'=> 'Pagina teste']);
        
     /*    $validations = new Validations;
        var_dump($validations->validations([
            'name_user' => 'required|regex:^[0-9]+$',
            'email_user' => "required|email|unique:users",
            'gender' => "required|in:Male,Female",
            'password' => "required|min:8",
            'date' => "date",
            'age' => 'not_in:33'

        ])); */




    }
}
