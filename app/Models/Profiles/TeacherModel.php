<?php

namespace App\Models\Profiles;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table      = 'profile_teacher';
    protected $primaryKey = 'teacher_id';
    protected $allowedFields = [
        'teacher_user_id', 
        'teacher_school_id', 
        'teacher_nip', 
        'teacher_nuptk', 
        'teacher_first_name', 
        'teacher_last_name', 
        'teacher_degree', 
        'teacher_nick_name', 
        'teacher_birth_date', 
        'teacher_gender', 
        'teacher_religion', 
        'teacher_image', 
        'teacher_phone', 
        'teacher_address', 
        'teacher_province', 
        'teacher_regency', 
        'teacher_subdistrict', 
        'teacher_postal_code', 
        'teacher_employment_status', 
        'teacher_is_teaching', 
        'teacher_status', 
        'teacher_created_by', 
        'teacher_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'teacher_created_at';
    protected $updatedField  = 'teacher_updated_at';
    
    public function show($id)
    {
        $sql = "
            SELECT au.user_email, au.user_name, ps.*
            FROM profile_teacher ps
            LEFT JOIN account_user au ON ps.teacher_user_id = au.user_id
            WHERE ps.teacher_id = $id
        ";

        return $this->db->query($sql)->getRowArray();
    }

    public function view_get_all()
    {
        $sql = "
            SELECT au.user_email, au.user_id, au.user_name, pt.*
            FROM profile_teacher pt
            LEFT JOIN account_user au ON pt.teacher_user_id = au.user_id
            WHERE pt.teacher_status < 9 AND pt.teacher_school_id = ".userdata()['id_profile']."
        ";

        return $this->db->query($sql)->getResultArray();
    }
   
    public function get_all()
    {
        $sql = "
            SELECT au.user_email, au.user_id, pt.*
            FROM profile_teacher pt
            LEFT JOIN account_user au ON pt.teacher_user_id = au.user_id
            WHERE pt.teacher_status < 9 AND pt.teacher_school_id = ".userdata()['id_profile']."
        ";

        return $this->db->query($sql)->getResult();
    }

}

