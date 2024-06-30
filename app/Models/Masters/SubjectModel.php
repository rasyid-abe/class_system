<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table      = 'master_subject';
    protected $primaryKey = 'subject_id';
    protected $allowedFields = [
        'subject_school_id', 
        'subject_major_id', 
        'subject_name', 
        'subject_grade', 
        'subject_description', 
        'subject_option', 
        'subject_status', 
        'subject_created_by', 
        'subject_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'subject_created_at';
    protected $updatedField  = 'subject_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

