<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterSemester extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'semester_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'semester_school_id' => [
                'type'       => 'INT',
            ],
            'semester_school_year_id' => [
                'type'       => 'INT',
            ],
            'semester_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'semester_start_date' => [
                'type'       => 'DATE',
            ],
            'semester_end_date' => [
                'type'       => 'DATE',
            ],
            'semester_created_at' => [
                'type' => 'DATETIME',
            ],
            'semester_created_by' => [
                'type' => 'BIGINT',
            ],
            'semester_updated_at' => [
                'type' => 'DATETIME',
            ],
            'semester_updated_by' => [
                'type' => 'BIGINT',
            ],
        ]);
        $this->forge->addKey('semester_id', true);
        $this->forge->createTable('system_semester');
    }

    public function down()
    {
        $this->forge->dropTable('system_semester');
    }
}
