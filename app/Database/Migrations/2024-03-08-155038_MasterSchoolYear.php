<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterSchoolYear extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'school_year_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'school_year_school_id' => [
                'type'       => 'INT',
            ],
            'school_year_periode' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'school_year_start_date' => [
                'type'       => 'DATE',
            ],
            'school_year_end_date' => [
                'type'       => 'DATE',
            ],
            'school_year_created_at' => [
                'type' => 'DATETIME',
            ],
            'school_year_created_by' => [
                'type' => 'BIGINT',
            ],
            'school_year_updated_at' => [
                'type' => 'DATETIME',
            ],
            'school_year_updated_by' => [
                'type' => 'BIGINT',
            ],
        ]);
        $this->forge->addKey('school_year_id', true);
        $this->forge->createTable('system_school_year');
    }

    public function down()
    {
        $this->forge->dropTable('system_school_year');
    }
}
