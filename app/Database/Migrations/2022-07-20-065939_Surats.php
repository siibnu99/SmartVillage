<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Surats extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id_surat'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '126',
            ],
            'id_user'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '126',
            ],
            'type'       => [
                'type'       => 'VARCHAR',
                'constraint' => '126',
                'null'    => true
            ],
            'status'       => [
                'type'       => 'INT',
                'constraint' => '2',
                'null'    => true
            ],
            'data'       => [
                'type'       => 'TEXT',
                'null'    => true
            ],
            'notif_in'       => [
                'type'       => 'INT',
                'constraint' => '2',
                'null'    => true
            ],
            'message'       => [
                'type'       => 'TEXT',
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
        $this->forge->addKey('id_surat', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('surats');
    }

    public function down()
    {
        //
        $this->forge->dropTable('surats');
    }
}
