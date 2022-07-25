<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '126',
            ],
            'nama_lengkap'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'tempat_lahir'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'tanggal_lahir'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'jenis_kelamin'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'pekerjaan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'nomor_ktp'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'id_dusun'       => [
                'type'       => 'INT',
                'constraint' => '2',
                'null'    => true
            ],
            'rt'       => [
                'type'       => 'INT',
                'constraint' => '2',
                'null'    => true
            ],
            'rw'       => [
                'type'       => 'INT',
                'constraint' => '2',
                'null'    => true
            ],
            'picture'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
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
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_details');
    }

    public function down()
    {
        //
        $this->forge->dropTable('user_details');
    }
}
