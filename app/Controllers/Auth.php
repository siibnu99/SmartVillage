<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        //
        $data = [
            'validation' => \Config\Services::validation(),
        ];
        return view('auth/login', $data);
    }
    public function loginAction()
    {
        if (!$this->validate([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
        ])) return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $this->UserModel->where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                $data = [
                    'auth' => [
                        'id_user' => $user->id_user,
                        'email' => $user->email,
                        'role_access' => $user->role_access,
                    ]
                ];
                session()->set($data);
                return redirect()->to(admin_url('dashboard'));
            } else {
                session()->setFlashdata('failed', 'Email atau Password salah!');
                return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            session()->setFlashdata('failed', 'Email atau Password salah!');
            return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(admin_url('/auth'));
    }
}
