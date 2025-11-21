<?php

namespace App\Controllers\Configs;

use App\Controllers\BaseController;
use App\Models\Configs\ActiveYearModel;
use App\Models\Management\StudentInGroupModel;
use App\Models\Masters\SchoolYearModel;
use Ramsey\Uuid\Uuid;

class ActiveYear extends BaseController
{
    protected $school_year;
    protected $active_year;
    protected $in_group;

    public function __construct()
    {
        $this->school_year = new SchoolYearModel();
        $this->active_year = new ActiveYearModel();
        $this->in_group = new StudentInGroupModel();
    }

    public function show_years()
    {
        $role = session()->get('c_role');

        if (in_array(12, $role)) {
            $data = $this->in_group
                ->select('student_in_group_school_year_id school_year_id, concat(school_year_period, " (Kelas : ", student_group_name, ")") school_year_period')
                ->join('master_school_year', 'school_year_id = student_in_group_school_year_id')
                ->join('master_student_group', 'student_group_id = student_in_group_student_group_id')
                ->where('student_in_group_student_id', userdata()['id_profile'])
                ->orderBy('student_in_group_school_year_id', 'desc')
                ->findAll();
        } else {
            $data = $this->school_year
                ->where('school_year_school_id', userdata()['school_id'])
                ->where('school_year_status < 9')
                ->orderBy('school_year_id', 'desc')
                ->findAll();
        }
        
        echo json_encode($data);
    }

    public function set_year()
    {
        $req = $this->request->getVar();
        $ret = false;
        $this->active_year->db->transBegin();
        try {
            $this->active_year
                ->where('active_year_school_id', userdata()['school_id'])
                ->where('active_year_user_id', userdata()['user_id'])
                ->where('active_year_type', 2)
                ->delete();

            $e1 = $this->active_year->error();

            if ($e1['code'] > 0) {
                throw new \Exception($e1['message']);
            }
    
            $data = [
                'active_year_id' => Uuid::uuid4()->toString(),
                'active_year_school_id' => userdata()['school_id'],
                'active_year_user_id' => userdata()['user_id'],
                'active_year_type' => 2,
                'active_year_school_year_id' => $req['year_id'],
                'active_year_status' => 1,
                'active_year_created_by' => userdata()['user_id'],
                'active_year_updated_by' => userdata()['user_id'],
            ];
            $this->active_year->save($data);

            $ret = true;
            $this->active_year->db->transCommit();
        } catch (\Throwable $th) {
            $this->active_year->db->transRollback();
            echo '<pre>';
            print_r($th);
            echo '</pre>';
            die;
        }


        echo json_encode($ret);
    }

}
