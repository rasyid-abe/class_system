<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class SchoolYearModel extends Model
{
    protected $table      = 'master_school_year';
    protected $primaryKey = 'school_year_id';
    protected $allowedFields = [
        'school_year_school_id', 
        'school_year_period', 
        'school_year_start_date_one', 
        'school_year_end_date_one', 
        'school_year_start_date_two', 
        'school_year_end_date_two', 
        'school_year_status', 
        'school_year_created_by', 
        'school_year_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'school_year_created_at';
    protected $updatedField  = 'school_year_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

