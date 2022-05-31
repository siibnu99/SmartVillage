<?php

namespace App\Database\Seeds;
use App\Libraries\Uuid;
use CodeIgniter\Database\Seeder;

class Users extends Seeder
{

    public function run()
    {
        $this->Uuid = new Uuid();
        $data = [
            'id_user' => $this->Uuid->v4(),
            'fullname' => 'Mohammad Ibnu',
            'email' => 'siibnu99@gmail.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'is_active' => 1,
            'role_access'=>2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ];
        // Using Query Builder
        $this->db->table('users')->replace($data);
    }
}
