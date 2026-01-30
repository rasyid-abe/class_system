<?php

namespace App\Models\Tasks;

use CodeIgniter\Model;

class TasksResultModel extends Model
{
    protected $table      = 'lms_task_result';
    protected $primaryKey = 'task_result_id';
    protected $allowedFields = [
        'task_result_id',
        'task_result_task_id', 
        'task_result_school_id', 
        'task_result_school_year_id', 
        'task_result_semester', 
        'task_result_group_id', 
        'task_result_student_id', 
        'task_result_begin_task_datetime', 
        'task_result_submit_datetime', 
        'task_result_end_datetime', 
        'task_result_answer', 
        'task_result_value', 
        'task_result_submit_type', 
        'task_result_submit_message', 
        'task_result_is_checked', 
    ];

    protected $useAutoIncrement = false; // penting
    
    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

}

