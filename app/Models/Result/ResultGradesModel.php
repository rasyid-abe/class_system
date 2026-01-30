<?php

namespace App\Models\Result;

use CodeIgniter\Model;

class ResultGradesModel extends Model
{
    protected $table      = 'lms_result_grades';
    protected $primaryKey = 'result_grades_id';
    protected $allowedFields = [
        'result_grades_school_id', 
        'result_grades_school_year_id', 
        'result_grades_semester', 
        'result_grades_first_half', 
        'result_grades_second_half', 
        'result_grades_group_id', 
        'result_grades_student_id', 
        'result_grades_value_type', 
        'result_grades_source_id', 
        'result_grades_source_title', 
        'result_grades_teacher_id', 
        'result_grades_subject_id', 
        'result_grades_original_value', 
        'result_grades_adjust_value',  
    ];

    protected $useTimestamps = true;
    protected $useAutoIncrement = false; // penting
    protected $createdField  = 'result_grades_created_at';
    protected $updatedField  = 'result_grades_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

}

