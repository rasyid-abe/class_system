<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterTeachingSchedule extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'teaching_schedule_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'teaching_schedule_school_id' => [
                'type'       => 'INT',
            ],
            'teaching_schedule_day' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'teaching_schedule_time' => [
                'type'       => 'TIME',
            ],
            'teaching_schedule_teaching_time' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'teaching_schedule_status' => [
                'type'       => 'TINYINT',
            ],
            'teaching_schedule_created_at' => [
                'type' => 'DATETIME',
            ],
            'teaching_schedule_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('teaching_schedule_id', true);
        $this->forge->createTable('master_teaching_schedule');
    }

    public function down()
    {
        $this->forge->dropTable('master_teaching_schedule');
    }
}
