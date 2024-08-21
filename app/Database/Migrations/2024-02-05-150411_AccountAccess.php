<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AccountAccess extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'access_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'access_role_id' => [
                'type'       => 'INT',
            ],
            'access_menu_id' => [
                'type'       => 'INT',
            ],
        ]);
        $this->forge->addKey('access_id', true);
        $this->forge->createTable('account_access');
    }

    public function down()
    {
        $this->forge->dropTable('account_access');
    }
}
