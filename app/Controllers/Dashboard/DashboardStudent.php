<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Assessment\AssessmentModel;
use App\Models\Tasks\TasksModel;
use App\Models\Tasks\TasksResultModel;
use App\Models\Tasks\TasksTempModel;
use App\Models\Lessons\SchoolLessonModel;
use App\Models\Lessons\StandartLessonModel;

class DashboardStudent extends BaseController
{
    protected $title;
    protected $assessment;
    protected $task;
    protected $task_result;
    protected $task_temp;
    protected $lesson_school;
    protected $lesson_standart;

    public function __construct()
    {
        $this->title = "Dashboard";
        $this->assessment = new AssessmentModel();
        $this->task = new TasksModel();
        $this->task_result = new TasksResultModel();
        $this->task_temp = new TasksTempModel();
        $this->lesson_school = new SchoolLessonModel();
        $this->lesson_standart = new StandartLessonModel();
    }

    public function index()
    {
        $data = array();
        $data["title"] = $this->title;
        $data["page"] = $this->title;
        $data["sidebar"] = $this->title;
        $data["sidebar"] = "Siswa";
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Siswa',
        ];

        $data['user'] = userdata();

        $assess = $this->assessment->get_list_student(1);
        $data['assessment'] = $assess;
        
        $task = $this->task->get_list_student_task(1);
        $my_task = $this->task_result
            ->select('task_result_task_id task_id')
            ->where('task_result_student_id', userdata()['id_profile'])
            ->findAll();

        $my_assign = array_column($my_task, 'task_id');
        $my_list = array_column($task, 'task_id');

        $merge_idx = array_merge($my_assign, $my_list);
        $list_idx = array_unique(array_diff_assoc($merge_idx, array_unique($merge_idx)));
        
        $my_temp = $this->task_temp
            ->select('task_temp_task_id')
            ->where([
                'task_temp_school_id' => userdata()['school_id'],
                'task_temp_student_id' => userdata()['id_profile'],
            ])->findAll();

        $arr_temp_task = array_column($my_temp, 'task_temp_task_id');
        
        $data['task'] = $task;
        $data['arr_temp_task'] = $arr_temp_task;
        $data['list_idx'] = $list_idx;

        $my_group = student_group();
        $sub_list = $this->lesson_school->student_list_subject($my_group['grade'], $my_group['group_id']);

        $std_less = $this->lesson_standart
            ->select('subject_id,subject_name,lesson_standart_id, lesson_standart_chapter, lesson_standart_subchapter')
            ->join('master_subject', 'subject_id=lesson_standart_subject_id', 'left')
            ->where('lesson_standart_grade', $my_group['grade'])
            ->where('lesson_standart_status < 9')
            ->groupBy('subject_id')
            ->findAll();

        $data['subj_school'] = $sub_list;
        $data['subj_standart'] = $std_less;
        $data['grade'] = $my_group['grade'];
        $data['group'] = $my_group['group_name'];

        return view("dashboard/student", $data);
    }

    public function change_password()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Siswa',
            '##' => 'Ubah Password',
        ];

        return view("dashboard/password", $data);
    }

    public function update_password()
    {
        if (
            !$this->validate([
                "old_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password harus diisi',
                    ]
                ],
                "new_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password baru harus diisi',
                        'min_length' => 'Minimal password harus 8 karakater',
                    ]
                ],
                "repeat_password" => [
                    'rules' => 'required|trim|matches[new_password]',
                    'errors' => [
                        'required' => 'Kolom ulangi password harus diisi',
                        'matches' => 'Password tidak sama'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }
        
        $req = $this->request->getVar();
        $upd = change_pass($req);

        if ($upd['status']) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to(userdata()['change_password']);
    }

   
}
