<?php

namespace App\Models\Configs;

use CodeIgniter\Model;

class MenuShortcutModel extends Model
{
    protected $table      = 'account_menu_shortcut';
    protected $primaryKey = 'menu_shortcut_id';
    protected $allowedFields = [
        'menu_shortcut_user_id', 
        'menu_shortcut_menu_id', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

