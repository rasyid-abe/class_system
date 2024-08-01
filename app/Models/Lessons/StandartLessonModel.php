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
        'lesson_standart_type', 
        'lesson_standart_title', 
        'lesson_standart_subtitle', 
        'lesson_standart_path', 
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
}

