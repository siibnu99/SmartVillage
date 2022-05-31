<?php

namespace App\Controllers;

use App\Libraries\Uuid;
use Exception;


class User extends BaseController
{
    protected $Uuid;
    public function __construct()
    {
        $this->Uuid = new Uuid;
    }
    public function index($id = null)
    {
        $data = ['title' => "User Management", 'id' => $id];
        return view('user/index', $data);
    }
    public function add()
    {
        $data = [
            'title' => "User Management",
            'validation' => \Config\Services::validation(),
        ];
        return view('user/add', $data);
    }
    public function addAttempt()
    {
        if (!$this->validate([
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|is_unique[users.email]|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'is_unique' => '{field} sudah terdaftar!',
                    'valid_email' => '{field} tidak sesuai format!',
                ]
            ],
            'fullname' => [
                'label'  => 'Nama Lengkap',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'role_access' => [
                'label'  => 'Role Access',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'min_length' => '{field} minimal 8 karakter!',
                ]
            ],
            're-password' => [
                'label'  => 'Re-Password',
                'rules'  => 'matches[password]',
                'errors' => [
                    'matches' => '{field} tidak sama',
                ]
            ],
        ])) return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $data = $this->request->getPostGet();
        $data['id_user'] =  $this->Uuid->v4();
        $data['is_active'] =  1;
        unset($data['re-password']);
        $data['password'] =  password_hash($data['password'], PASSWORD_DEFAULT);
        $this->UserModel->save($data);
        $this->session->setFlashdata('message', 'User ' . $data['fullname'] . ' berhasil dibuat');
        cache()->delete('user.' . $data['id_user']);
        return redirect()->to(admin_url('user'));
    }
    public function edit($id = null)
    {
        $dataUser = $this->UserModel->find($id);
        if (!$dataUser) {
            $this->session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(admin_url('user'));
        }
        $data = [
            'title' => "User Management",
            'validation' => \Config\Services::validation(),
            'data' => $dataUser
        ];
        return view('user/edit', $data);
    }
    public function editAttempt()
    {
        $data = $this->request->getPostGet();
        $dataUser = $this->UserModel->find($data['id_user']);
        if (!$dataUser) {
            $this->session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(admin_url('user'));
        }
        $dataUser->email == $data['email'] ? $ruleEmail = 'required|valid_email' : $ruleEmail = 'required|is_unique[user.email]|valid_email';
        if (!$this->validate([
            'email' => [
                'label'  => 'Email',
                'rules'  => $ruleEmail,
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'is_unique' => '{field} sudah terdaftar!',
                    'valid_email' => '{field} tidak sesuai format!',
                ]
            ],
            'fullname' => [
                'label'  => 'Nama Lengkap',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
            'role_access' => [
                'label'  => 'Role Access',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!',
                ]
            ],
        ])) return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $this->UserModel->save($data);
        $this->session->setFlashdata('message', 'User ' . $data['fullname'] . ' berhasil diedit');
        cache()->delete('user.' . $data['id_user']);
        return redirect()->to(admin_url('user'));
    }
    public function password($id = null)
    {
        $dataUser = $this->UserModel->select("id_user")->find($id);
        if (!$dataUser) {
            $this->session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(admin_url('user'));
        }
        $data = [
            'title' => "User Management",
            'validation' => \Config\Services::validation(),
            'data' => $dataUser
        ];
        return view('user/password', $data);
    }
    public function passwordAttempt()
    {
        $data = $this->request->getPostGet();
        $dataUser = $this->UserModel->find($data['id_user']);
        if (!$dataUser) {
            $this->session->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->to(admin_url('user'));
        }
        if (!$this->validate([
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'min_length' => '{field} minimal 8 karakter!',
                ]
            ],
            're-password' => [
                'label'  => 'Re-Password',
                'rules'  => 'matches[password]',
                'errors' => [
                    'matches' => '{field} tidak sama',
                ]
            ],
        ])) return redirect()->to($_SERVER['HTTP_REFERER'])->withInput()->with('errors', $this->validator->getErrors());
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['re-password']);
        $this->UserModel->save($data);
        $this->session->setFlashdata('message', 'User ' . (isset($dataUser->fullname) ? $dataUser->fullname :  $dataUser->email) . ' berhasil diedit');
        cache()->delete('user.detail.' . $data['id_user']);
        return redirect()->to(admin_url('user'));
    }
    public function deleteAttempt()
    {
        $data = $this->request->getPostGet();
        $dataUser = $this->UserModel->find((string) $data['id']);
        try {
            $this->UserModel->delete($data['id']);
            $message = "User : " . $dataUser->fullname . " berhasil dihapus";
            $output = [
                "message" => $message,
                csrf_token() => csrf_hash()
            ];
        } catch (Exception $e) {
            $message = "User : " . $dataUser->fullname . " gagal dihapus";
            $output = [
                "message" => $message,
                csrf_token() => csrf_hash()
            ];
        }
        echo json_encode($output);
    }
    public function toggleActiveAttempt()
    {
        $data = $this->request->getPostGet();
        $dataUser = $this->UserModel->find((string) $data['id']);
        $save = [
            'is_active' => $dataUser->is_active ? 0 : 1
        ];
        $message = $dataUser->is_active ? "Dinonaktifkan" : "Diaktifkan";

        try {
            $this->UserModel->update($data['id'], $save);
            $message = "user : " . $dataUser->email . " Berhasil " . $message;
            $output = [
                "message" => $message,
                csrf_token() => csrf_hash()
            ];
        } catch (Exception $e) {
            $message = "user : " . $dataUser->email . " gagal " . $message;
            $output = [
                "message" => $message,
                csrf_token() => csrf_hash(),
                "error" => $e
            ];
        }
        echo json_encode($output);
    }
    public function listdata($id = null)
    {
        $m_icd = $this->UserModel;
        if ($this->request->getPost()) {
            $lists = $m_icd->get_datatables($id);
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->email;
                $row[] = role_access($list->role_access)[2];
                $row[] = $list->is_active == 0  ? '<span class="badge badge-sm bg-gradient-secondary">Deactive</span> ' : '<span class="badge badge-sm bg-gradient-success">Active</span> ';
                $row[] =  '
                <button type="button" class="btn bg-gradient-warning btn-sm px-2 m-0  btnActive" data-id="' . $list->id_user . '">' . icon_active('white') . '</button>
                <a href="' . admin_url('user/cpassword/' . $list->id_user) . '" role="button" class="btn bg-gradient-info btn-sm px-2 m-0">' . icon_cpassword('white') . '</a>
                <a href="' . admin_url('user/edit/' . $list->id_user) . '" role="button" class="btn bg-gradient-success btn-sm px-2 m-0">' . icon_edit('white') . '</a>
                <button type="button" class="btn bg-gradient-danger btn-sm px-2 m-0  btnDelete" data-id="' . $list->id_user . '">' . icon_delete('white') . '</button>
                ';
                $data[] = $row;
            }
            $output = [
                "draw" => $this->request->getPost('draw'),
                "recordsTotal" => $m_icd->count_all($id),
                "recordsFiltered" => $m_icd->count_filtered($id),
                "data" => $data,
                csrf_token() => csrf_hash()
            ];
            echo json_encode($output);
        }
    }
}
