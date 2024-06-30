<?php

namespace App\Models\Authentication;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table      = 'account_token';
    protected $primaryKey = 'token_id';
    protected $allowedFields = [
        'token_email', 
        'token_code', 
        'token_time', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

