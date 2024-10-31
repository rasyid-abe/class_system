<?php

namespace App\Controllers\Configs;

use App\Controllers\BaseController;
use App\Models\Configs\ActiveYearModel;
use App\Models\Masters\SchoolYearModel;


class ActiveYear extends BaseController
{
    protected $school_year;
    protected $active_year;
    public function __construct()
    {
        $this->school_year = new SchoolYearModel();
        $this->active_year = new ActiveYearModel();
    }

    public function show_years()
    {
        $data = $this->school_year
            ->where('school_year_status < 9')
            ->where('school_year_school_id', userdata()['school_id'])
            ->orderBy('school_year_id', 'desc')
            ->findAll();
        
        echo json_encode($data);
    }

    public function set_year()
    {
        $req = $this->request->getVar();
        $sts = '';

        $chk = $this->active_year
            ->where('active_year_user_id', userdata()['user_id'])
            ->findAll();
        
        if (count($chk) < 1) {
            $data = [
                'active_year_school_id' => userdata()['school_id'],
                'active_year_user_id' => userdata()['user_id'],
                'active_year_school_year_id' => $req['year_id'],
                'active_year_created_by' => userdata()['user_id'],
                'active_year_updated_by' => userdata()['user_id'],
            ];
            $this->active_year->save($data);
        } else {
            $this->active_year
                ->where('active_year_user_id', userdata()['user_id'])
                ->set('active_year_updated_by', userdata()['user_id'])
                ->set('active_year_school_year_id', $req['year_id'])
                ->update();
        }

        echo json_encode(true);
    }

}
