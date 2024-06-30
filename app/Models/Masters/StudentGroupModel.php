<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class StudentGroupModel extends Model
{
    protected $table      = 'master_student_group';
    protected $primaryKey = 'student_group_id';
    protected $allowedFields = [
        'student_group_school_id', 
        'student_group_major_id', 
        'student_group_grade', 
        'student_group_name', 
        'student_group_quota', 
        'student_group_description', 
        'student_group_homeroom_teacher_id', 
        'student_group_status', 
        'student_group_created_by', 
        'student_group_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'student_group_created_at';
    protected $updatedField  = 'student_group_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();
    }

    public function list_group($param)
    {
        $query = "
            SELECT * FROM master_student_group 
            WHERE student_group_grade = ".$param['code']."
            AND student_group_school_id = ".userdata()['school_id']."
            AND student_group_status = 1
        ";
        return $this->db->query($query)->getResultArray();
    }

    public function group_name()
    {
        $sql ="
            SELECT student_group_id, student_group_name
            FROM master_student_group
            WHERE student_group_school_id = ".userdata()['school_id']."
            AND student_group_status = 1
        ";
        $res = $this->db->query($sql)->getResultArray();
        return array_column($res, 'student_group_name', 'student_group_id');
    }
}

