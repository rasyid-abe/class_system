<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class TeachingScheduleModel extends Model
{
    protected $table      = 'master_teaching_schedule';
    protected $primaryKey = 'teaching_schedule_id';
    protected $allowedFields = [
        'teaching_schedule_school_id', 
        'teaching_schedule_day', 
        'teaching_schedule_order', 
        'teaching_schedule_time', 
        'teaching_schedule_status', 
        'teaching_schedule_created_by', 
        'teaching_schedule_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'teaching_schedule_created_at';
    protected $updatedField  = 'teaching_schedule_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

