<?php

namespace App\Models\QuestionBank;

use CodeIgniter\Model;

class QuestionBankModel extends Model
{
    protected $table      = 'lms_question_bank_standart';
    protected $primaryKey = 'question_bank_standart_id';
    protected $allowedFields = [
        'question_bank_standart_phase', 
        'question_bank_standart_grade', 
        'question_bank_standart_subject_id',
        'question_bank_standart_type', 
        'question_bank_standart_title', 
        'question_bank_standart_subtitle', 
        'question_bank_standart_question', 
        'question_bank_standart_option', 
        'question_bank_standart_answer',
        'question_bank_standart_status', 
        'question_bank_standart_created_by', 
        'question_bank_standart_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'question_bank_standart_created_at';
    protected $updatedField  = 'question_bank_standart_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

