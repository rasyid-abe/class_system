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
                student_gender,
                student_address,
                student_phone,
            ')
            ->join('profile_student', 'student_id=student_in_group_student_id', 'left')
            ->where('student_in_group_student_group_id',$req['id'])
            ->where('student_in_group_school_year_id',year_active()['school_year_id'])
            ->where('student_in_group_status < 9')
            ->findAll();

            $data = [];
            foreach ($get as $k => $v) {
                $gender = $v['student_gender'] == 1 ? 'Laki-laki' : 'Perempuan';
                $religi = get_list('religion')[$v['student_religion']];
                $lists = '
                    <div class="row bigrow-tabulator">
                        <div class="col-lg-4 mx-auto">
                            <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-start">
                        
                                <div class="d-flex flex-column">
                                    <div class="cursor-pointer symbol symbol-50px" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="User profile">
                                        <img src="http://localhost:8080/assets/media/avatars/150-26.jpg" alt="image">
                                    </div>
                                </div>
                        
                                <div class="flex-grow-1 me-2 mx-5 center">
                                <h6>'.$v['student_first_name'].' '.$v['student_last_name'].'</h6>
                                <span class="text-gray-700 d-block">
                                    <badge class="badge badge-primary" onclick="lesson_preview(18, 2, 15)">NISN: '.$v['student_nisn'].'</badge>
                                </span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                            <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                <span class="text-gray-800 fw-bold">'.$gender.'</span>
                                <span class="text-gray-800 fw-bold">'.$religi.'</span>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-700 fw-bold">HP: '.$v['student_phone'].' </span>
                                    <span class="text-gray-700 fw-bold">Alamat: '.$v['student_address'].'</span>
                                </div>
                            </div>
                        </div>
                        </div>
                ';
                $data[] = [
                    'id' => $v['student_id'],
                    'lists' => $lists
                ];
            }
    
            echo (json_encode($data));
    }

}