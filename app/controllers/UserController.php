<?php

namespace app\controllers;

class UserController
{
  public function store()
  {
    echo "Cdastrar";
  }
  public function show(string|array $param)
  {
    echo json_encode(['action' => 'show', 'data' => $param]);
    die;
  }
  public function delete(string|array $param)
  {
    echo json_encode(['action' => 'delete', 'data' => $param]);
    die;
  }
}
