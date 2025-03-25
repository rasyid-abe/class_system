<?php

namespace App\Models\Tasks;

use CodeIgniter\Model;

class TasksTempModel extends Model
{
    protected $table      = 'lms_task_temp';
    protected $primaryKey = 'task_temp_id';
    protected $allowedFields = [
        'task_temp_id',
        'task_temp_school_id', 
        'task_temp_student_id', 
        'task_temp_subject_id', 
        'task_temp_task_id', 
        'task_temp_data', 
        'task_temp_created', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

}

