<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SystemStudentInGroup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'student_in_group_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_in_group_school_id' => [
                'type'       => 'INT',
            ],
            'student_in_group_year_periode' => [
                'type'       => 'TINYINT',
            ],
            'student_in_group_semester' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'student_in_group_nisn' => [
                'type'       => 'INT',
            ],
            'student_in_group_student_class_id' => [
                'type'       => 'INT',
            ],
            'student_in_group_status' => [
                'type'       => 'TINYINT',
            ],
            'student_in_group_created_at' => [
                'type' => 'DATETIME',
            ],
            'student_in_group_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('student_in_group_id', true);
        $this->forge->createTable('system_student_in_group');
    }

    public function down()
    {
        $this->forge->dropTable('system_student_in_group');
    }
}
