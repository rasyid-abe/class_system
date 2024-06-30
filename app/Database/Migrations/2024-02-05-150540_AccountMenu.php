<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AccountMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menu_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'menu_parent' => [
                'type'       => 'INT',
                'null'       => true,
            ],
            'menu_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'menu_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
                'null'       => true,
            ],
            'menu_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
            ],
            'menu_sort' => [
                'type'       => 'TINYINT',
                'null'       => true,
            ],
            'menu_status' => [
                'type'       => 'TINYINT',
            ],
            'menu_created_at' => [
                'type' => 'DATETIME',
            ],
            'menu_updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('menu_id', true);
        $this->forge->createTable('account_menu');
    }

    public function down()
    {
        $this->forge->dropTable('account_menu');
    }
}
