<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $UserModel = new UserModel();
        $data = session('auth');
        if ($data === NULL) {
            session()->setFlashdata('failed', 'Anda belum login, silahkan login!</br> atau hubungi admin');
            return redirect()->to(admin_url('auth'));
        }
        $user =  $UserModel->where('role_access >=', 2)->find($data['id_user']);
        if (!$user || $user->is_active == 0) {
            session()->remove('auth');
            session()->setFlashdata('failed', 'Mohon aktivasi user terlebih dahulu!</br> atau hubungi admin');
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
        if ($arguments == NULL) return;
        foreach ($arguments as $item) {
            if (session('roleAccess') == $item) return;
        }
        session()->setFlashdata('success', 'Selamat datang kembali di dashboard');
        return redirect()->to(admin_url('dashboard'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
