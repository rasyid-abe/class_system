<?php

namespace App\Models\QuestionBank;

use CodeIgniter\Model;

class StandartQuestionBankModel extends Model
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
        'question_bank_standart_parent_id', 
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

    public function list_subject($grade) 
    {
        $query = "
            SELECT
                sta.teacher_assign_teacher_id,
                sta.teacher_assign_subject_id,
                sta.teacher_assign_grade,
                ms.subject_name,
                qbs.question_bank_standart_id,
                count(qbs.question_bank_standart_title) total
            FROM system_teacher_assign sta
            LEFT JOIN master_subject ms ON
                ms.subject_id = sta.teacher_assign_subject_id
            LEFT JOIN (select qbs.question_bank_standart_id, qbs.question_bank_standart_grade, question_bank_standart_subject_id, question_bank_standart_title 
                from lms_question_bank_standart qbs WHERE qbs.question_bank_standart_status < 9 and question_bank_standart_grade = ".$grade."
                group by qbs.question_bank_standart_title
                ) qbs 
                ON qbs.question_bank_standart_grade = question_bank_standart_grade
                AND qbs.question_bank_standart_subject_id = ms.subject_id 
            WHERE
                sta.teacher_assign_school_id = ".userdata()['school_id']."
                AND sta.teacher_assign_grade = ".$grade."
            GROUP BY sta.teacher_assign_subject_id
        ";

        return $this->db->query($query)->getResultArray();
    }

    public function list_first_page($grade) 
    {
        $query = "
            SELECT
                qbs.question_bank_standart_id,
                ms.subject_name,
                ms.subject_id,
                qbs.question_bank_standart_title as title,
                qbs.question_bank_standart_parent_id as parent,
                LEFT(qbs.question_bank_standart_question, 20) as question
            FROM
                lms_question_bank_standart qbs
            JOIN master_subject ms ON
                qbs.question_bank_standart_subject_id = ms.subject_id
            WHERE
                qbs.question_bank_standart_grade = $grade
        ";

        return $this->db->query($query)->getResultArray();

    }
}

