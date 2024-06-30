<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterRoom extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'room_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'room_school_id' => [
                'type'       => 'INT',
            ],
            'room_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'room_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'room_quota' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => true,
            ],
            'room_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'room_status' => [
                'type'       => 'TINYINT',
            ],
            'room_created_at' => [
                'type' => 'DATETIME',
            ],
            'room_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('room_id', true);
        $this->forge->createTable('master_room');
    }

    public function down()
    {
        $this->forge->dropTable('master_room');
    }
}
