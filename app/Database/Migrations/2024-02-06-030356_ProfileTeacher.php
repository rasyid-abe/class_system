<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileTeacher extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'teacher_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'teacher_user_id' => [
                'type'       => 'BIGINT',
            ],
            'teacher_school_id' => [
                'type'       => 'INT',
            ],
            'teacher_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
            ],
            'teacher_nuptk' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
            ],
            'teacher_first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'teacher_last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'teacher_nick_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => true,
            ],
            'teacher_degree' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'null'       => true,
            ],
            'teacher_religion' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'teacher_gender' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'teacher_image' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'teacher_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'teacher_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'teacher_province' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => true,
            ],
            'teacher_regency' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'teacher_subdistrict' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => true,
            ],
            'teacher_postal_code' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'teacher_is_teaching' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
            ],
            'teacher_status_employement' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
            ],
            'teacher_is_homeroom' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'null'       => true,
            ],
            'teacher_status' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'null'       => true,
            ],
            'teacher_created_at' => [
                'type' => 'DATETIME',
            ],
            'teacher_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('teacher_id', true);
        $this->forge->createTable('profile_teacher');
    }

    public function down()
    {
        $this->forge->dropTable('profile_teacher');
    }
}
