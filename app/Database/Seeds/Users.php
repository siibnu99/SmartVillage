<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            'id_user' => '1',
            'email' => 'siibnu99@gmail.com',
            'password' => password_hash('ikilo123', PASSWORD_DEFAULT),
            'role_access' => '2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('users')->replace($data);
        $data = [
            'id_user' => '1',
            'nama_lengkap' => 'Mohammad ibnu',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('user_details')->replace($data);
    }
}
