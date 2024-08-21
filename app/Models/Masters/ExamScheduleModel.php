<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class ExamScheduleModel extends Model
{
    protected $table      = 'master_exam_schedule';
    protected $primaryKey = 'exam_schedule_id';
    protected $allowedFields = [
        'exam_schedule_school_id', 
        'exam_schedule_day', 
        'exam_schedule_order', 
        'exam_schedule_time', 
        'exam_schedule_status', 
        'exam_schedule_created_by', 
        'exam_schedule_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'exam_schedule_created_at';
    protected $updatedField  = 'exam_schedule_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

