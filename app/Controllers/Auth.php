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
    // public function register()
    // {
    //     //
    //     $data = [
    //         'validation' => \Config\Services::validation(),
    //     ];
    //     return view('auth/register', $data);
    // }
    // public function registerAction()
    // {
    //     if (!$this->validate([
    //         'email' => [
    //             'label'  => 'Email',
    //             'rules'  => 'required|is_unique[users.email]',
    //             'errors' => [
    //                 'required' => '{field} harus diisi!',
    //                 'is_unique' => '{field} telah terdaftar'
    //             ]
    //         ],
    //         'password' => [
    //             'label'  => 'Password',
    //             'rules'  => 'required|min_length[8]',
    //             'errors' => [
    //                 'required' => '{field} harus diisi!',
    //                 'min_length' => '{field} minimal 8 karakter!'
    //             ]
    //         ],
    //         're-password' => [
    //             'label'  => 'Re-Password',
    //             'rules'  => 'required|matches[password]',
    //             'errors' => [
    //                 'required' => '{field} harus diisi!',
    //                 'matches' => '{field} harus sama dengan password'
    //             ]
    //         ],
    //     ])) return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
    //     $data = [
    //         'id_user' => $this->Uuid->v4(),
    //         'email' => $this->request->getVar('email'),
    //         'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
    //         'role_access' => 2,
    //     ];
    //     $user = $this->Users->insert($data);
    //     if ($user) {
    //         session()->setFlashdata('success', 'Berhasil mendaftar! <br> Silahkan login menggunakan email yang sudah didaftarkan');
    //         return redirect()->to(admin_url('/auth'));
    //     } else {
    //         session()->setFlashdata('failed', 'Gagal mendaftar!');
    //         return redirect()->to(admin_url('/auth/register'));
    //     }
    // }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(admin_url('/auth'));
    }
}
