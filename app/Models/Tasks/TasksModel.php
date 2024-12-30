<?php

namespace App\Models\Tasks;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table      = 'lms_tasks';
    protected $primaryKey = 'task_id';
    protected $allowedFields = [
        'task_school_id', 
        'task_teacher_id', 
        'task_grade', 
        'task_subject_id', 
        'task_subject_name', 
        'task_group', 
        'task_title', 
        'task_lesson_id', 
        'task_lesson_name', 
        'task_lesson_src', 
        'task_task_ids', 
        'task_start', 
        'task_end', 
        'task_is_autosubmit', 
        'task_instruction',
        'task_status', 
        'task_created_by', 
        'task_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'task_created_at';
    protected $updatedField  = 'task_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

