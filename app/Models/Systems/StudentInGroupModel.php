<?php

namespace App\Models\Systems;

use CodeIgniter\Model;

class StudentInGroupModel extends Model
{
    protected $table      = 'system_student_in_group';
    protected $primaryKey = 'student_in_group_id';
    protected $allowedFields = [
        'student_in_group_school_id', 
        'student_in_group_student_group_id', 
        'student_in_group_grade', 
        'student_in_group_student_id', 
        'student_in_group_nisn', 
        'student_in_group_status', 
        'student_in_group_created_by', 
        'student_in_group_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'student_in_group_created_at';
    protected $updatedField  = 'student_in_group_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();
    }

    public function list_for_assessment($group_id, $school_id, $religion)
    {
        $whr_religi = '';
        if ($religion != 0) {
            $whr_religi = ' AND student_religion = '. $religion;
        }

        $sql = "
            SELECT
                student_in_group_student_id,
                student_religion
            FROM system_student_in_group 
            LEFT JOIN profile_student ON student_id=system_student_in_group.student_in_group_student_id
            WHERE 1=1 
                AND student_in_group_student_group_id = $group_id 
                AND system_student_in_group.student_in_group_school_id = $school_id
                $whr_religi
        ";
     
        return $this->db->query($sql)->getResultArray();
    }

}

