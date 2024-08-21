<?php

namespace App\Models\Systems;

use CodeIgniter\Model;

class TeacherAssignModel extends Model
{
    protected $table      = 'system_teacher_assign';
    protected $primaryKey = 'teacher_assign_id';
    protected $allowedFields = [
        'teacher_assign_school_id', 
        'teacher_assign_school_year_id', 
        'teacher_assign_teacher_id', 
        'teacher_assign_subject_id', 
        'teacher_assign_student_group_id', 
        'teacher_assign_teaching_schedule_id',
        'teacher_assign_room_id', 
        'teacher_assign_status', 
        'teacher_assign_created_by', 
        'teacher_assign_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'teacher_assign_created_at';
    protected $updatedField  = 'teacher_assign_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();
    }

}

