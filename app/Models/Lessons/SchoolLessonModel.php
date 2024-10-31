<?php

namespace App\Models\Lessons;

use CodeIgniter\Model;

class SchoolLessonModel extends Model
{
    protected $table      = 'lms_lesson_school';
    protected $primaryKey = 'lesson_school_id';
    protected $allowedFields = [
        'lesson_school_school_id', 
        'lesson_school_school_year_id', 
        'lesson_school_teacher_id', 
        'lesson_school_subject_id', 
        'lesson_school_grade', 
        'lesson_school_chapter', 
        'lesson_school_lesson_standart_id', 
        'lesson_school_lesson_additional_id', 
        'lesson_school_lesson_shared_id', 
        'lesson_school_status', 
        'lesson_school_created_by', 
        'lesson_school_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'lesson_school_created_at';
    protected $updatedField  = 'lesson_school_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

    public function get_list()
    {
        $sql = "
            select 
                lla.lesson_additional_grade,
                lla.lesson_additional_subject_id,
                lla.lesson_additional_chapter,
                lla.lesson_additional_subchapter,
                lla.lesson_additional_content,
                lla.lesson_additional_content_path,
                lla.lesson_additional_video_path,
                lla.lesson_additional_attachment_path,
                lla.lesson_additional_tasks,
                'additional' as source_lesson
            from lms_lesson_school lls
            left join lms_lesson_additional lla on lla.lesson_additional_id = lls.lesson_school_lesson_additional_id 
            where lls.lesson_school_lesson_standart_id = 0
            UNION 
            select 
                ls.lesson_standart_grade, 
                ls.lesson_standart_subject_id, 
                ls.lesson_standart_chapter, 
                ls.lesson_standart_subchapter, 
                ls.lesson_standart_content, 
                ls.lesson_standart_content_path, 
                ls.lesson_standart_video_path, 
                ls.lesson_standart_attachment_path, 
                ls.lesson_standart_tasks,
                'standard' as source_lesson
            from lms_lesson_school lls2 
            left join lms_lesson_standart ls on ls.lesson_standart_id = lls2.lesson_school_lesson_standart_id
            where lls2.lesson_school_lesson_additional_id = 0
        ";

        return $this->db->query($query)->getResultArray();
    }
}

