<?php

namespace App\Models\Profiles;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'profile_student';
    protected $primaryKey = 'student_id';
    protected $allowedFields = [
        'student_user_id', 
        'student_school_id', 
        'student_nisn', 
        'student_first_name', 
        'student_last_name', 
        'student_birth_place', 
        'student_birth_date', 
        'student_religion', 
        'student_gender', 
        'student_image', 
        'student_phone', 
        'student_address', 
        'student_province', 
        'student_regency', 
        'student_subdistrict', 
        'student_postal_code', 
        'student_is_transfer', 
        'student_registered_date', 
        'student_grade_start', 
        'student_registered_information', 
        'student_previous_school', 
        'student_child_order_in_family', 
        'student_father_name', 
        'student_father_occupation', 
        'student_mother_name', 
        'student_mother_occupation', 
        'student_parent_phone', 
        'student_parent_address', 
        'student_parent_postal_code', 
        'student_guardian_name', 
        'student_guardian_occupation', 
        'student_guardian_phone', 
        'student_guardian_address', 
        'student_guardian_postal_code', 
        'student_status', 
        'student_created_by', 
        'student_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'student_created_at';
    protected $updatedField  = 'student_updated_at';

    public function show($id)
    {
        $sql = "
            SELECT au.user_email, au.user_name, ps.*, ssig.student_in_group_grade grade, ssig.student_in_group_student_group_id student_group
            FROM profile_student ps
            LEFT JOIN account_user au ON ps.student_user_id = au.user_id
            LEFT JOIN system_student_in_group ssig ON ps.student_id = ssig.student_in_group_student_id
            WHERE ps.student_id = $id
        ";

        return $this->db->query($sql)->getRowArray();
    }

    public function get_all()
    {
        $sql = "
            SELECT au.user_id, au.user_email, ps.*, ssig.student_in_group_grade grade, ssig.student_in_group_id, msg.student_group_name
            FROM profile_student ps
            LEFT JOIN account_user au ON ps.student_user_id = au.user_id
            LEFT JOIN system_student_in_group ssig ON ps.student_id = ssig.student_in_group_student_id
            LEFT JOIN master_student_group msg ON ssig.student_in_group_student_group_id = msg.student_group_id
            WHERE ps.student_status < 9 AND ps.student_school_id = ".userdata()['school_id']."
            ORDER BY ps.student_registered_date ASC
        ";

        return $this->db->query($sql)->getResult();
    }

    public function list_student()
    {
        $sql = "
            SELECT 
                ps.student_id, ps.student_image, ps.student_first_name, ps.student_last_name, ps.student_nisn, ps.student_status,
                ssig.student_in_group_grade grade, msg.student_group_name
            FROM profile_student ps
            LEFT JOIN system_student_in_group ssig ON ps.student_id = ssig.student_in_group_student_id
            LEFT JOIN master_student_group msg ON ssig.student_in_group_student_group_id = msg.student_group_id
            WHERE ps.student_status < 9 AND ps.student_school_id = ".userdata()['school_id']."
        ";

        return $this->db->query($sql)->getResultArray();
    }


}

