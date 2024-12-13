<?php

namespace App\Models\Assessment;

use CodeIgniter\Model;

class AssessmentModel extends Model
{
    protected $table      = 'lms_assessment';
    protected $primaryKey = 'assessment_id';
    protected $allowedFields = [
        'assessment_school_id', 
        'assessment_teacher_id', 
        'assessment_grade', 
        'assessment_subject_id', 
        'assessment_group', 
        'assessment_title', 
        'assessment_question_bank_id', 
        'assessment_start', 
        'assessment_end', 
        'assessment_duration', 
        'assessment_is_random', 
        'assessment_is_autosubmit', 
        'assessment_instruction',
        'assessment_status', 
        'assessment_created_by', 
        'assessment_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'assessment_created_at';
    protected $updatedField  = 'assessment_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

