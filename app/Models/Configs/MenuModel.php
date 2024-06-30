<?php

namespace App\Models\Configs;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table      = 'account_menu';
    protected $primaryKey = 'menu_id';
    protected $allowedFields = [
        'menu_parent', 
        'menu_name', 
        'menu_icon', 
        'menu_url', 
        'menu_sort', 
        'menu_status', 
        'menu_created_by', 
        'menu_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'menu_created_at';
    protected $updatedField  = 'menu_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

