<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    protected $table      = 'master_semester';
    protected $primaryKey = 'semester_id';
    protected $allowedFields = [
        'semester_school_id', 
        'semester_school_period_id', 
        'semester_name', 
        'semester_start_date', 
        'semester_end_date', 
        'semester_status', 
        'semester_created_by', 
        'semester_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'semester_created_at';
    protected $updatedField  = 'semester_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

