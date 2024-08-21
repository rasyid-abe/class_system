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
        'lesson_school_lesson_standart_id', 
        'lesson_school_lesson_additional_id', 
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
}

