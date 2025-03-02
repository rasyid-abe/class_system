<?php

namespace App\Models\Assessment;

use CodeIgniter\Model;

class AssessmentResultModel extends Model
{
    protected $table      = 'lms_assessment_result';
    protected $primaryKey = 'assessment_result_id';
    protected $allowedFields = [
        'assessment_result_id',
        'assessment_result_assessment_id', 
        'assessment_result_school_id', 
        'assessment_result_school_year_id',
        'assessment_result_group_id', 
        'assessment_result_student_id', 
        'assessment_result_begin_assignment_datetime', 
        'assessment_result_submit_datetime', 
        'assessment_result_end_datetime', 
        'assessment_result_answer', 
        'assessment_result_value', 
        'assessment_result_fault', 
        'assessment_result_submit_message', 
    ];

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

}

