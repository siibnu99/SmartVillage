<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ApiUser extends BaseController
{
    public function login()
    {
        if (!$this->validate([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'valid_email' => '{field} tidak valid'
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
        ])) return json_encode([
            'status' => 400,
            'message' => $this->validator->getErrors(),
        ]);
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $this->UserModel->where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                $data = [
                    'id_user' => $user->id_user,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                ];
                $token = $this->TokenJwt->getToken($data);
                return json_encode([
                    'status' => 200,
                    'token' => $token,
                ]);
            } else {
                return json_encode([
                    'status' => 400,
                    'message' =>  'Email atau Password salah!',
                ]);
            }
        }
    }
    public function register()
    {
        if (!$this->validate([
            'fullname' => [
                'label'  => 'Nama lengkap',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|is_unique[users.email]|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'is_unique' => '{field} telah terdaftar',
                    'valid_email' => '{field} tidak valid'
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'min_length' => '{field} minimal 8 karakter!'
                ]
            ],
            'rePassword' => [
                'label'  => 'Re-Password',
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'matches' => '{field} harus sama dengan password'
                ]
            ],
        ])) return json_encode([
            'status' => 400,
            'message' => $this->validator->getErrors(),
        ]);
        $data = [
            'id_user' => $this->Uuid->v4(),
            'fullname' => $this->request->getVar('fullname'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role_access' => 1,
            'is_active' => 1,
        ];
        $user = $this->UserModel->insert($data);
        if ($user) {
            return json_encode([
                'status' => 200,
                'message' => 'Berhasil mendaftar!Silahkan login menggunakan email yang sudah didaftarkan',
            ]);
        } else {
            return json_encode([
                'status' => 201,
                'message' => 'Gagal mendaftar! Silahkan hubungi admin',
            ]);
        }
    }
    public function user()
    {
        $user = $this->UserModel->select("fullname,email,is_active")->where('id_user', $this->request->auth->id_user)->first();
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
