<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileStudent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'student_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_user_id' => [
                'type'       => 'BIGINT',
            ],
            'student_school_id' => [
                'type'       => 'INT',
            ],
            'student_nisn' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => true,
            ],
            'student_first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'student_last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'student_birth_place' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
            ],
            'student_birth_date' => [
                'type'       => 'DATE',
            ],
            'student_religion' => [
                'type'       => 'TINYINT',
                'constraint' => '2',
            ],
            'student_gender' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
            ],
            'student_image' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'student_phone' => [
                'type'       => 'VARCHAR',
                'null'       => true,
            ],
            'student_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'student_province' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => true,
            ],
            'student_regency' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'student_subdistrict' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => true,
            ],
            'student_postal_code' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'student_is_transfer' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'student_registered_date' => [
                'type'       => 'DATE',
            ],
            'student_registered_information' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'student_previous_school' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_child_order_in_family' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'null'       => true,
            ],
            'student_father_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_father_occupation' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_mother_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_mother_occupation' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_parent_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'student_parent_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'student_parent_postal_code' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'student_guardian_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_guardian_occupation' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'student_guardian_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'student_guardian_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'student_guardian_postal_code' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'student_status' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'null'       => true,
            ],
            'student_created_at' => [
                'type' => 'DATETIME',
            ],
            'student_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('student_id', true);
        $this->forge->createTable('profile_student');
    }

    public function down()
    {
        $this->forge->dropTable('profile_student');
    }
}
