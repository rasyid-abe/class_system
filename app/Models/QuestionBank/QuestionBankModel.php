<?php

namespace App\Models\QuestionBank;

use CodeIgniter\Model;

class QuestionBankModel extends Model
{
    protected $table      = 'lms_question_bank';
    protected $primaryKey = 'question_bank_id';
    protected $allowedFields = [
        'question_bank_school_id', 
        'question_bank_teacher_id', 
        'question_bank_subject_id', 
        'question_bank_grade', 
        'question_bank_type', 
        'question_bank_title', 
        'question_bank_subtitle', 
        'question_bank_question', 
        'question_bank_option', 
        'question_bank_answer',  
        'question_bank_poin',  
        'question_bank_hint',  
        'question_bank_explain',  
        'question_bank_shared_type',
        'question_bank_shared_to',  
        'question_bank_status', 
        'question_bank_parent_id', 
        'question_bank_created_by', 
        'question_bank_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'question_bank_created_at';
    protected $updatedField  = 'question_bank_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

