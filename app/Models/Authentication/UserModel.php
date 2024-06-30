<?php

namespace App\Models\Authentication;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'account_user';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'user_name', 
        'user_email', 
        'user_password', 
        'user_role_id', 
        'user_status', 
        'user_is_trial',
        'user_email_verified',
        'user_created_by',
        'user_updated_by'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'user_created_at';
    protected $updatedField  = 'user_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

