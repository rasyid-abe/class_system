<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class MajorModel extends Model
{
    protected $table      = 'master_major';
    protected $primaryKey = 'major_id';
    protected $allowedFields = [
        'major_school_id', 
        'major_name', 
        'major_description', 
        'major_status', 
        'major_created_by', 
        'major_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'major_created_at';
    protected $updatedField  = 'major_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

