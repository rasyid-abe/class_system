<?php

namespace App\Models\Lessons;

use CodeIgniter\Model;

class StandartLessonModel extends Model
{
    protected $table      = 'lms_lesson_standart';
    protected $primaryKey = 'lesson_standart_id';
    protected $allowedFields = [
        'lesson_standart_phase', 
        'lesson_standart_grade', 
        'lesson_standart_subject_id', 
        'lesson_standart_chapter', 
        'lesson_standart_subchapter', 
        'lesson_standart_content', 
        'lesson_standart_content_path', 
        'lesson_standart_summary_path', 
        'lesson_standart_attachment_path', 
        'lesson_standart_tasks', 
        'lesson_standart_status', 
        'lesson_standart_created_by', 
        'lesson_standart_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'lesson_standart_created_at';
    protected $updatedField  = 'lesson_standart_updated_at';

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

