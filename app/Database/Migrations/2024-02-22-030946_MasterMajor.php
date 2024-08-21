<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterMajor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'major_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'major_school_id' => [
                'type'       => 'INT',
            ],
            'major_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'major_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'major_status' => [
                'type'       => 'TINYINT',
            ],
            'major_created_at' => [
                'type' => 'DATETIME',
            ],
            'major_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('major_id', true);
        $this->forge->createTable('master_major');
    }

    public function down()
    {
        $this->forge->dropTable('master_major');
    }
}
