<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\Systems\StudentInGroupModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Masters\StudentGroupModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Lessons\SchoolLessonModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\QuestionBank\PublicQuestionBankModel;
use App\Models\Assessment\AssessmentModel;
use App\Models\Tasks\TasksModel;

class DashboardTeacher extends BaseController
{
    protected $title;
    protected $tgroup;
    protected $tassign;
    protected $stugroup;
    protected $qb_public;
    protected $qb_addition;
    protected $less_addition;
    protected $less_public;
    protected $less_school;
    protected $assessment;
    protected $task;

    public function __construct()
    {
        $this->title = "Dashboard";
        $this->tgroup = new StudentInGroupModel();
        $this->tassign = new TeacherAssignModel();
        $this->qb_public = new PublicQuestionBankModel();
        $this->qb_addition = new QuestionBankModel();
        $this->less_addition = new AdditionalLessonModel();
        $this->less_public = new PublicLessonModel();
        $this->less_school = new SchoolLessonModel();
        $this->assessment = new AssessmentModel();
        $this->task = new TasksModel();

    }
    public function index()
    {
        $data["title"] = 'Dashboard';
        $data["page"] = 'Dashboard';
        $data["sidebar"] = 'Dashboard';
        $data["breadcrumb"] = [
        ];

        return view("dashboard/teacher", $data);
    }

    public function change_password()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Guru',
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

    public function data_dashboard()
    {
        $year = year_active()['school_year_id'];
        $school_id = userdata()['school_id'];
        $teacher_id = userdata()['id_profile'];

        $my_duty = $this->tassign
            ->select('
                subject_id,
                subject_name,
                teacher_assign_grade,
                student_group_name,
            ')
            ->join('master_subject', 'subject_id=teacher_assign_subject_id', 'left')
            ->join('master_student_group', 'student_group_id=teacher_assign_student_group_id', 'left')
            ->where([
                'teacher_assign_school_id' => $school_id,
                'teacher_assign_school_year_id' => $year,
                'teacher_assign_teacher_id' => $teacher_id,
                'teacher_assign_status < 9',
            ])->findAll();

        $grade = teacher_grades($teacher_id);
        $subject_id = teacher_subjects($teacher_id);
        $public_qb = $this->qb_public->get_shared_qb($teacher_id, $subject_id, $grade);
  
        $total_quespub = array_sum(array_column($public_qb, 'qb_total'));

        $total_title = $this->qb_addition
            ->select('count(*) as total')
            ->where('question_bank_status < 9')
            ->where('question_bank_school_id', $school_id)
            ->where('question_bank_teacher_id', $teacher_id)
            ->where('question_bank_parent_id', 0)
            ->first();
        $total_quest = $this->qb_addition
            ->select('count(*) as total')
            ->where('question_bank_status < 9')
            ->where('question_bank_school_id', $school_id)
            ->where('question_bank_teacher_id', $teacher_id)
            ->where('question_bank_parent_id > 1')
            ->first();

        $pless = $this->less_public->get_shared($teacher_id, $subject_id, $grade);
       
        $pub = [];
        foreach ($pless as $k => $v) {
            $pub[$v['lesson_additional_subject_id']]['subject_name'] = $v['subject_name'];
            $pub[$v['lesson_additional_subject_id']]['subject_id'] = $v['lesson_additional_subject_id'];
            $pub[$v['lesson_additional_subject_id']]['chapter'][$v['lesson_additional_chapter']] = $v['lesson_additional_chapter'];
            $pub[$v['lesson_additional_subject_id']]['subchapter'][$v['lesson_additional_subchapter']] = $v['lesson_additional_subchapter'];
        }

        $pc = $psc = 0; 
        foreach ($pub as $v) {
            $pc += count($v['chapter']);
            $psc += count($v['subchapter']);
        }

        $total_add_chapter = $this->less_addition->my_chapter($school_id, $teacher_id);
        $total_add_subchap = $this->less_addition->my_subchapter($school_id, $teacher_id);

        $total_sch_chapter = $this->less_school->total_chapter($school_id, $year, $teacher_id);
        $total_sch_subchap = $this->less_school->total_subchapter($school_id, $year, $teacher_id);

        $sharedless = $this->less_addition->my_shared_lesson($school_id, $teacher_id);
        $sc_shared = array_sum(array_column($sharedless, 'total_subchap'));

        $date_now = date('Y-m-d H:i:s');
        $select_assessement = 'count(assessment_id) as total';
        $select_task = 'count(task_id) as total';

        $assessment_draft = $this->assessment->data_draft($select_assessement, $school_id, $teacher_id);
        $assessment_scheduled = $this->assessment->data_scheduled($select_assessement, $date_now, $school_id, $teacher_id);
        $assessment_present = $this->assessment->data_present($select_assessement, $date_now, $school_id, $teacher_id);
        $assessment_done = $this->assessment->data_done($select_assessement, $date_now, $school_id, $teacher_id);

        $task_draft = $this->task->data_draft($select_task, $school_id, $teacher_id, $date_now);
        $task_scheduled = $this->task->data_scheduled($select_task, $school_id, $teacher_id, $date_now);
        $task_present = $this->task->data_present($select_task, $school_id, $teacher_id, $date_now);
        $task_done = $this->task->data_done($select_task, $school_id, $teacher_id, $date_now);

        $result = [
            'my_duty' => $my_duty,
            'total_less_add_chap' => count($total_add_chapter),
            'total_less_add_subchap' => count($total_add_subchap),
            'total_less_chap' => count($total_add_chapter) + $total_sch_chapter['total'] + $pc,
            'total_less_subchap' => count($total_add_subchap) + $total_sch_subchap['total'] + $psc,
            'total_less_sch_chap' => $total_sch_chapter['total'],
            'total_less_sch_subchap' => $total_sch_subchap['total'],
            'total_less_pub_chap' => $pc,
            'total_less_pub_subchap' => $psc,
            'total_less_share_chap' => count($sharedless),
            'total_less_share_subchap' => $sc_shared,
            'total_qb_me' => $total_quest['total'],
            'total_qb_pub' => $total_quespub,
            'total_qb_title' => count($public_qb) + $total_title['total'],
            'total_qb_quest' => $total_quespub + $total_quest['total'],
            'as_draft' => $assessment_draft[0]['total'],
            'as_scheduled' => $assessment_scheduled[0]['total'],
            'as_present' => $assessment_present[0]['total'],
            'as_done' => $assessment_done[0]['total'],
            'tk_draft' => $task_draft[0]['total'],
            'tk_scheduled' => $task_scheduled[0]['total'],
            'tk_present' => $task_present[0]['total'],
            'tk_done' => $task_done[0]['total'],
        ];

        echo json_encode($result);
    }
   
}
