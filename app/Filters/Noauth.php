<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Noauth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $UserModel = new UserModel();
        $data = session('auth');
        if ($data !== NULL) {
            $user =  $UserModel->where('role_access >=', 2)->find($data['id_user']);
            if (!$user) {
                session()->remove('idUser');
                session()->setFlashdata('failed', 'Terjadi kesalahan dalam pengambilan session! atau hubungi admin');
                return redirect()->to(admin_url('auth'));
            }
            $saveData = [
                'auth' => [
                    'id_user' => $user->id_user,
                    'role_access' => $user->role_access,
                    'email' => $user->email,
                ]
            ];
            session()->set($saveData);
            session()->setFlashdata('success', 'Selamat datang kembali di dashboard');
            return redirect()->to(admin_url('dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
