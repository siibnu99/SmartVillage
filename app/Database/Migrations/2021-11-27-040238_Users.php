<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '126',
            ],
            'number_user'          => [
                'type'           => 'INT',
                'constraint'     => '10',
                'auto_increment' => true,
            ],
            'fullname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
            ],
            'password'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'is_active'       => [
                'type'       => 'BOOLEAN',
                'default'        => false,
            ],
            'role_access'       => [
                'type'       => 'INT',
                'constraint' => '2',
            ],
            'token_active'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null' => true,
            ],
            'token_active_expired'       => [
                'type'       => 'TIMESTAMP',
                'null' => true,
            ],
            'token_forgot'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null' => true,
            ],
            'token_forgot_expired'       => [
                'type'       => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at'       => [
                'type'       => 'TIMESTAMP',
                'null'           => true,
            ],
            'updated_at'       => [
                'type'       => 'TIMESTAMP',
                'null'           => true,
            ],
            'deleted_at'       => [
                'type'       => 'TIMESTAMP',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->addKey('number_user', false);
        $this->forge->addKey('email');
        $this->forge->addKey('token_active');
        $this->forge->addKey('token_forgot');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
