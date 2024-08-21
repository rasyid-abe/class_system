<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AccountRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'role_slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'role_description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'role_status' => [
                'type'       => 'TINYINT',
            ],
        ]);
        $this->forge->addKey('role_id', true);
        $this->forge->createTable('account_role');
    }

    public function down()
    {
        $this->forge->dropTable('account_role');
    }
}
