<?php

namespace App\Models\Profiles;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $table = 'profile_school';
    protected $primaryKey = 'school_id';
    protected $allowedFields = [
        'school_user_id',
        'school_npsn',
        'school_name',
        'school_alias',
        'school_foundation',
        'school_level',
        'school_principal',
        'school_principal_nip',
        'school_principal_sign',
        'school_phone',
        'school_wa',
        'school_logo',
        'school_website',
        'school_map_latitude',
        'school_map_longitude',
        'school_address',
        'school_province',
        'school_regency',
        'school_subdistrict',
        'school_postal_code',
        'school_status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'school_created_at';
    protected $updatedField = 'school_updated_at';

    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function list_school()
    {
        $sql = "
            SELECT 
                ps.school_id,
                ps.school_npsn,
                ps.school_name,
                ps.school_level,
                ps.school_logo,
                ps.school_status
            FROM account_user au
            LEFT JOIN profile_school ps ON au.user_id = ps.school_user_id
            WHERE au.user_role_id = 3 AND ps.school_status < 9
            ORDER BY ps.school_name ASC
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function get_all()
    {
        $sql = "
            SELECT au.user_email, ps.*
            FROM profile_school ps
            LEFT JOIN account_user au ON ps.school_user_id = au.user_id
            WHERE ps.school_status < 9
            ORDER BY ps.school_name ASC
        ";

        return $this->db->query($sql)->getResult();
    }

    public function show($id)
    {
        $sql = "
            SELECT au.user_email, au.user_email_verified, ps.*
            FROM profile_school ps
            LEFT JOIN account_user au ON ps.school_user_id = au.user_id
            WHERE ps.school_id = $id
        ";

        return $this->db->query($sql)->getRowArray();
    }
}

