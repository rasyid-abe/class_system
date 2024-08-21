<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterSubject extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'subject_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'subject_school_id' => [
                'type'       => 'INT',
            ],
            'subject_major_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'subject_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'subject_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'subject_grade' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => true,
            ],
            'subject_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'subject_option' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
            ],
            'subject_status' => [
                'type'       => 'TINYINT',
            ],
            'subject_created_at' => [
                'type' => 'DATETIME',
            ],
            'subject_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('subject_id', true);
        $this->forge->createTable('master_subject');
    }

    public function down()
    {
        $this->forge->dropTable('master_subject');
    }
}
