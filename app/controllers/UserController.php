<?php

namespace app\controllers;

class UserController
{
    public function show(string|array $param){
        echo "Nome: {$param[0]} <br>Id: {$param[1]}";
    }
    public function delete(string|array $param){
        echo "id: {$param} <br> DELETANDO 3, 2, 1 ...";
    }
}
