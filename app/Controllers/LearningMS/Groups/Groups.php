<?php

namespace App\Controllers\LearningMS\Groups;

use App\Controllers\BaseController;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Systems\StudentInGroupModel;
use App\Models\Masters\StudentGroupModel;

class Groups extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $sgroup;
    protected $ingroup;

    public function __construct()
    {
        $this->title = "Mengajar di Kelas";
        $this->page = "Groups";
        $this->sidebar = "Groups";
        $this->sgroup = new StudentGroupModel();
        $this->ingroup = new StudentInGroupModel();
    }

    public function view_students($id)
    {
        $gr = $this->sgroup->where('student_group_id', $id)->select('student_group_name')->first();

        $data["title"] = $gr['student_group_name'];
        $data["page"] = $this->page;
        $data["sidebar"] = $gr['student_group_name'];
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => $gr['student_group_name'],
        ];

        $data['group_id'] = $id;
        
        return view("learningms/groups/index", $data);
    }
    
    public function get_list_students()
    {
        $req = $this->request->getVar();
        $get = $this->ingroup
            ->select('
                student_id,
                student_nisn,
                student_first_name,
                student_last_name,
                student_religion,
                student_gender
            ')
            ->join('profile_student', 'student_id=student_in_group_student_id', 'left')
            ->where('student_in_group_student_group_id',$req['id'])
            ->where('student_in_group_school_year_id',year_active()['school_year_id'])
            ->where('student_in_group_status < 9')
            ->findAll();

            $data = [];
            foreach ($get as $k => $v) {
                $data[] = [
                    'id' => $v['student_id'],
                    'nisn' => $v['student_nisn'],
                    'name' => $v['student_first_name'] .' '. $v['student_last_name'],
                    'religion' => $v['student_religion'],
                    'gender' => $v['student_gender'],
                ];
            }
    
            echo (json_encode($data));
    }

}