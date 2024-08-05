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
        'lesson_additional_type', 
        'lesson_additional_chapter', 
        'lesson_additional_subchapter', 
        'lesson_additional_content', 
        'lesson_additional_path', 
        'lesson_additional_is_share',
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
}

