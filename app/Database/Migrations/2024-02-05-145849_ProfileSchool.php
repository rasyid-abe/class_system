<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileSchool extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'school_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'school_user_id' => [
                'type'       => 'BIGINT',
            ],
            'school_npsn' => [
                'type'       => 'BIGINT',
            ],
            'school_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'school_alias' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'school_foundation' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'school_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => true,
            ],
            'school_principal' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'school_principal_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
            ],
            'school_principal_sign' => [
                'type'       => 'TEXT',
            ],
            'school_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'school_wa' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'null'       => true,
            ],
            'school_logo' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'school_website' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'null'       => true,
            ],
            'school_map_latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'null'       => true,
            ],
            'school_map_longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '32',
                'null'       => true,
            ],
            'school_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'school_province' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => true,
            ],
            'school_regency' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'school_subdistrict' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'null'       => true,
            ],
            'school_postal_code' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'school_status' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
                'null'       => true,
            ],
            'school_created_at' => [
                'type' => 'DATETIME',
            ],
            'school_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('school_id', true);
        $this->forge->createTable('profile_school');
    }

    public function down()
    {
        $this->forge->dropTable('profile_school');
    }
}
