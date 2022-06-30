<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiUser extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function show($id = null)
    {
        $user = $this->UserModel->where('id_user', $id)->first();
        if ($user) {
            return json_encode([
                'status' => 200,
                'data' => $user,
            ]);
        } else {
            return json_encode([
                'status' => 400,
                'message' => 'User tidak ditemukan!',
            ]);
        }
    }
}
