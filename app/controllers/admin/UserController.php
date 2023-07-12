<?php

namespace app\controllers\admin;

class UserController
{
    public function edit(array $data)
    {
        echo json_encode(['action' => 'admin editar', 'data' => $data]);
    }
    public function delete()
    {
        echo "admin deletar";
    }
}
