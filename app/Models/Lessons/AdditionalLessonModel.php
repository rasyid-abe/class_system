<?php

namespace App\Models\Lessons;

use CodeIgniter\Model;

class AdditionalLessonModel extends Model
{
    protected $table      = 'lms_lesson_additional';
    protected $primaryKey = 'lesson_additional_id';
    protected $allowedFields = [
        'lesson_additional_school_id', 
        'lesson_additional_teacher_id', 
        'lesson_additional_subject_id', 
        'lesson_additional_grade', 
        'lesson_additional_chapter', 
        'lesson_additional_subchapter', 
        'lesson_additional_content', 
        'lesson_additional_content_path', 
        'lesson_additional_video_path', 
        'lesson_additional_summary_path', 
        'lesson_additional_attachment_path', 
        'lesson_additional_tasks', 
        'lesson_additional_shared_type',
        'lesson_additional_shared_to',  
        'lesson_additional_status', 
        'lesson_additional_created_by', 
        'lesson_additional_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'lesson_additional_created_at';
    protected $updatedField  = 'lesson_additional_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

    public function my_chapter($school, $teacher)
    {
        $sql = "
            select
                lla.lesson_additional_chapter
            from
                lms_lesson_additional lla
            where
                lla.lesson_additional_teacher_id = $teacher
                and lla.lesson_additional_school_id = $school
                and lla.lesson_additional_status < 9
            group by
                lla.lesson_additional_chapter, lla.lesson_additional_subject_id
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function my_subchapter($school, $teacher)
    {
        $sql = "
            select
                distinct lla.lesson_additional_subchapter 
            from
                lms_lesson_additional lla
            where
                lla.lesson_additional_teacher_id = $teacher
                and lla.lesson_additional_school_id = $school
                and lla.lesson_additional_status < 9
                and lla.lesson_additional_subchapter <> ''
            group by
	            lla.lesson_additional_chapter,
	            lla.lesson_additional_subchapter 
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function my_shared_lesson($school, $teacher)
    {
        $sql = "
            select
                lesson_additional_chapter,
                count(lesson_additional_subchapter) total_subchap
            from
                lms_lesson_additional
            where
                lesson_additional_status < 9
                and lesson_additional_school_id = $school
                and lesson_additional_teacher_id = $teacher
                and lesson_additional_shared_type > 0
            group by lesson_additional_chapter
        ";

        return $this->db->query($sql)->getResultArray();
    }
}

