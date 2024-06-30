<?php

namespace App\Models\Configs;

use CodeIgniter\Model;

class AccessModel extends Model
{
    protected $table      = 'account_access';
    protected $primaryKey = 'access_id';
    protected $allowedFields = [
        'access_role_id', 
        'access_menu_id', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

