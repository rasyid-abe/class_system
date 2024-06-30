<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterGroup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'student_group_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_group_school_id' => [
                'type'       => 'INT',
            ],
            'student_group_major_id' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'student_group_grade' => [
                'type'       => 'TINYINT',
            ],
            'student_group_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'student_group_quota' => [
                'type'       => 'TINYINT',
            ],
            'student_group_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_group_homeroom_teacher_id' => [
                'type'       => 'TINYINT',
                'null'       => true,
            ],
            'student_group_status' => [
                'type'       => 'TINYINT',
            ],
            'student_group_created_at' => [
                'type' => 'DATETIME',
            ],
            'student_group_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('student_group_id', true);
        $this->forge->createTable('master_student_group');
    }

    public function down()
    {
        $this->forge->dropTable('master_student_group');
    }
}
