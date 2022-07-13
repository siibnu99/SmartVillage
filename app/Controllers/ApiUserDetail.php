<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class ApiUserDetail extends BaseController
{
    use ResponseTrait;
    public function getOnce()
    {
        $id = $this->request->auth->user_id;
        $phone = $this->request->auth->phone_number;
        $dataUser = $this->UserDetail->where('id_user', $id)->first();
        if ($dataUser) {
            return $this->respond($dataUser, 200);
        } else {
            if ($this->UserModel->where('id_user', $id)->first() || $this->UserModel->where('phone', $phone)->first()) {
                return $this->respond([
                    'status' => 400,
                    'message' => 'Email atau Nomor telepon sudah terdaftar!',
                ], 400);
            } else {
                try {
                    $this->UserModel->save([
                        'id_user' => $id,
                        'phone' => $phone,
                        'is_active' => 1,
                        'role_access' => 1,
                    ]);
                    $dataUser = $this->UserModel->where('id_user', $id)->where("phone", $phone)->first();
                    return $this->respond($dataUser, 200);
                } catch (\Throwable $th) {
                    return $this->respond([
                        'status' => 400,
                        'message' => 'Gagal mendaftar!',
                        'error' => $th->getMessage(),
                    ], 400);
                }
            }
        }
        dd($this->model->find($id));
        return $this->respond("asd");
    }
}
