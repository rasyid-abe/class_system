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
        'assessment_subject_name', 
        'assessment_group', 
        'assessment_title', 
        'assessment_question_bank_id', 
        'assessment_question_bank_title', 
        'assessment_question_bank_src', 
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

    public function get_draft()
    {
        $teacher = userdata()['id_profile'];
        $query = "
            SELECT
                sta.teacher_assign_teacher_id,
                sta.teacher_assign_subject_id,
                sta.teacher_assign_grade,
                ms.subject_name,
                lls.lesson_standart_id,
                count(lls.lesson_standart_chapter) total
            FROM system_teacher_assign sta
            LEFT JOIN master_subject ms ON
                ms.subject_id = sta.teacher_assign_subject_id
            LEFT JOIN (select lls.lesson_standart_id, lls.lesson_standart_grade, lesson_standart_subject_id, lesson_standart_chapter 
                from lms_lesson_standart lls WHERE lls.lesson_standart_status < 9 and lesson_standart_grade = ".$grade."
                group by lls.lesson_standart_chapter
                ) lls 
                ON lls.lesson_standart_grade = lesson_standart_grade
                AND lls.lesson_standart_subject_id = ms.subject_id 
            WHERE
                sta.teacher_assign_school_id = ".userdata()['school_id']."
                AND sta.teacher_assign_grade = ".$grade."
            GROUP BY sta.teacher_assign_subject_id
        ";

        return $this->db->query($query)->getResultArray();
    }
}

