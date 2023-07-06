<?php

namespace app\controllers;

class NotFoundController
{
    public function index()
    {
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint não encontrado']);
        die;
    }
}
