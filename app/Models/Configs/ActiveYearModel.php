<?php

namespace App\Models\Configs;

use CodeIgniter\Model;

class ActiveYearModel extends Model
{
    protected $table      = 'account_active_year';
    protected $primaryKey = 'active_year_id';
    protected $allowedFields = [
        'active_year_school_id', 
        'active_year_user_id', 
        'active_year_school_year_id', 
        'active_year_created_by', 
        'active_year_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'active_year_created_at';
    protected $updatedField  = 'active_year_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

