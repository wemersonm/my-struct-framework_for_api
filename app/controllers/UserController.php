<?php

namespace app\controllers;

class UserController
{
  public function store()
  {
    echo "Cadastrar";
  }
  public function show(string|array $param)
  {
    echo json_encode(['action' => 'show', 'data' => $param]);
    die;
  }
 
}
