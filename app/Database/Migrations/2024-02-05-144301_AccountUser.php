<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AccountUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_password' => [
                'type'       => 'TEXT',
            ],
            'user_role_id' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'user_status' => [
                'type'       => 'TINYINT',
                'constraint' => '4',
            ],
            'user_is_trial' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
            ],
            'user_created_at' => [
                'type' => 'DATETIME',
            ],
            'user_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('account_user');
    }

    public function down()
    {
        $this->forge->dropTable('account_user');
    }
}
