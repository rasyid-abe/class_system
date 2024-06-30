<?php

namespace App\Models\Configs;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table      = 'account_role';
    protected $primaryKey = 'role_id';
    protected $allowedFields = [
        'role_name', 
        'role_slug', 
        'role_description', 
        'role_status', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

