<?php

namespace App\Controllers\LearningMS\Assessment;

use App\Controllers\BaseController;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\QuestionBank\PublicQuestionBankModel;
use App\Models\Assessment\AssessmentModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;

class Assessment extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $teacher_subject;
    protected $question_bank;
    protected $question_bank_standart;
    protected $question_bank_public;
    protected $teacher;
    protected $subject;
    protected $assessment;

    public function __construct()
    {
        $this->title = "Penilaian";
        $this->page = "Assessment";
        $this->sidebar = "Draft_Assessment";
        $this->question_bank = new QuestionBankModel();
        $this->question_bank_standart = new StandartQuestionBankModel();
        $this->question_bank_public = new PublicQuestionBankModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->assessment = new AssessmentModel();
    }

    public function index()
    {
        $data["title"] = 'Tambah Penilaian';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Add_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Tambah Penilaian',
        ];

        $te_duty = $this->teacher_subject->get_teacher_duty(userdata()['id_profile']);

        $list_grade = get_list('grade')[school_level(userdata()['school_id'])];
        $grade = $group = $subs = $sub = [];
        foreach ($te_duty as $k => $v) {
            $sub[$v['subject_id']] = $v['subject_name'];

            $subs[$v['subject_id']]['subjs'] = $v['subject_name'];
            $subs[$v['subject_id']]['subjs_id'] = $v['subject_id'];
            $subs[$v['subject_id']]['grade'][$v['student_group_grade']] = 'Kelas '.$list_grade[$v['student_group_grade']];


            $group[$v['student_group_id']] = $v['student_group_name'];
            $grade[$v['student_group_grade']]['grade'] = 'Kelas '.$list_grade[$v['student_group_grade']];
            $grade[$v['student_group_grade']]['subjs'][$v['subject_id']] = $v['subject_name'];
        }

        $data['sub'] = $sub;
        $data['grd'] = $list_grade;

        $data['my_duty'] = $subs;

        return view("learningms/assessment/index", $data);
    }

    public function data_option()
    {
        $req = $this->request->getVar();

        $ex = $this->teacher_subject
            ->join('master_student_group', 'student_group_id=teacher_assign_student_group_id')
            ->where('teacher_assign_school_id', userdata()['school_id'])
            ->where('teacher_assign_school_year_id', year_active()['school_year_id'])
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->where('teacher_assign_subject_id', $req['subs'])
            ->where('teacher_assign_grade', $req['grad'])
            ->where('teacher_assign_status < 9')
            ->findAll();

        $arr_group = [];
        if ($ex) {
            foreach ($ex as $k => $v) {
                $arr_group[$k]['id'] = $v['teacher_assign_student_group_id'];
                $arr_group[$k]['name'] = $v['student_group_name'];
            }

            echo json_encode($arr_group);
        } else {
            echo json_encode(false);
        }
    }

    public function view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'] . ' - Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/question-bank/additional' => 'Bank Soal Saya',
            '##' => $subs['subject_name'] . ' - Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title')
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_status < 9')
            ->where('question_bank_subject_id', $subject)
            ->where('question_bank_grade', $grade)
            ->where('question_bank_parent_id', 0)
            ->findAll();
        
        foreach ($question as $k => $v) {
            $child = $this->question_bank
                ->select('question_bank_id, question_bank_parent_id')
                ->where('question_bank_parent_id', $v['question_bank_id'])
                ->where('question_bank_status < 9')
                ->findAll();
            $question[$k]['child'] = array_chunk($child, 5);
        }

        $data['questions'] = $question;
        $data['quest_type'] = get_list('question_type');

        $data['teachers'] = $this->teacher
            ->select('teacher_id, teacher_first_name, teacher_last_name, teacher_degree')
            ->where('teacher_school_id', userdata()['school_id'])
            ->where('teacher_id <> '. userdata()['id_profile'])
            ->findAll();

        return view("learningms/question_bank_additional/content", $data);
    }

    public function view_question_bank()
    {
        $req = $this->request->getVar();

        $std = $this->question_bank_standart
            ->select('question_bank_standart_id as id, question_bank_standart_title as title, "std" as source')
            ->where('question_bank_standart_subject_id', $req['subj'])
            ->where('question_bank_standart_grade', $req['grad'])
            ->where('question_bank_standart_parent_id', 0)
            ->where('question_bank_standart_status < 9')
            ->findAll();

        $me = $this->question_bank->select('question_bank_id as id, question_bank_title as title, "me" as source')
            ->where('question_bank_subject_id', $req['subj'])
            ->where('question_bank_grade', $req['grad'])
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_parent_id', 0)
            ->where('question_bank_status < 9')
            ->findAll();

        $pub = $this->question_bank_public->get_list_title(userdata()['id_profile'], [$req['subj']], [$req['grad']]);

        foreach ($std as $k => $v) {
            $ch_std = $this->question_bank_standart
                ->select('question_bank_standart_id as id')
                ->where('question_bank_standart_parent_id', $v['id'])
                ->where('question_bank_standart_status < 9')
                ->findAll();

            $std[$k]['child'] = $ch_std;
        }

        foreach ($me as $k => $v) {
            $ch_me = $this->question_bank->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $me[$k]['child'] = $ch_me;
        }

        foreach ($pub as $k => $v) {
            $ch_pub = $this->question_bank->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $pub[$k]['child'] = $ch_pub;
        }

        $res = [
            'std' => ['head' => 'Bank Soal Standart', 'content' => $std, 'src' => 1],
            'me' => ['head' => 'Bank Soal Saya', 'content' => $me, 'src' => 2],
            'pub' => ['head' => 'Bank Soal Publik', 'content' => $pub, 'src' => 3],
        ];

        echo json_encode([
            'res' => $res, 
            'sub_name' => subject_rowid($req['subj'])['subject_name'],
            'grd_name' => get_list('grade')[school_level(userdata()['school_id'])][$req['grad']]
        ]);
    }

    public function store_data()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 1) {
            $d = json_decode($req['data']);
    
            $group = [];
            foreach ($d[3] as $k => $v) {
                $group[$k]['id'] = $v->id; 
                $group[$k]['group'] = $v->text; 
            }
    
            $data = [
                'assessment_school_id' => userdata()['school_id'],
                'assessment_teacher_id' => userdata()['id_profile'],
                'assessment_grade' => $d[2],
                'assessment_subject_id' => $d[1],
                'assessment_subject_name' => $d[13],
                'assessment_group' => json_encode($group),
                'assessment_title' => $d[0],
                'assessment_question_bank_id' => $d[11],
                'assessment_question_bank_title' => $d[12],
                'assessment_question_bank_src' => $d[14],
                'assessment_start' => date('Y-m-d H:i:s', strtotime($d[4].':00')),
                'assessment_end' => date('Y-m-d H:i:s', strtotime($d[5].':00')),
                'assessment_duration' => $d[6],
                'assessment_is_random' => $d[7],
                'assessment_is_autosubmit' => $d[9],
                'assessment_is_prevent_cheat' => $d[8],
                'assessment_instruction' => $d[10],
                'assessment_status' => 1,
            ];
    
            $ins = $this->assessment->insert($data);
            $res = [
                'typ' => $req['type'],
                'sts' => $ins,
                'msg' => $ins ? 'Penilaian berhasil ditambahkan' : 'Penilaian gagal ditambahkan',
                'icn' => $ins ? 'success' : 'error',
            ];
            echo json_encode($res);

        } else if ($req['type'] == 2) {
            $upd = $this->assessment
                ->where('assessment_id', $req['id'])
                ->set('assessment_status', 2)
                ->update();

            $res = [
                'typ' => $req['type'],
                'sts' => $upd,
                'msg' => $upd ? 'Penilaian berhasil di publish' : 'Penilaian gagal di publish',
                'icn' => $upd ? 'success' : 'error',
            ];
            echo json_encode($res);
        }
    }

    public function index_draft()
    {
        $data["title"] = 'Draft';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Draft_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Draft',
        ];

        return view("learningms/assessment/draft", $data);
    }

    public function index_scheduled()
    {
        $data["title"] = 'Terjadwal';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Scheduled_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Terjadwal',
        ];

        return view("learningms/assessment/scheduled", $data);
    }

    public function index_present()
    {
        $data["title"] = 'Saat Ini';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Present_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Saat Ini',
        ];

        return view("learningms/assessment/present", $data);
    }

    public function index_done()
    {
        $data["title"] = 'Selesai';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Done_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        return view("learningms/assessment/done", $data);
    }

    public function list_assessment()
    {
        $req = $this->request->getVar();

        if ($req['page-ass'] == 1) {
            $get = $this->assessment
                ->where('assessment_status', 1)
                ->where('assessment_school_id', userdata()['school_id'])
                ->where('assessment_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-ass'] == 2) {
            $get = $this->assessment
                ->where('assessment_status', 2)
                // ->where('assessment_end <=', date('Y-m-d H:i:s'))
                ->where('assessment_school_id', userdata()['school_id'])
                ->where('assessment_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-ass'] == 3) {
            $get = $this->assessment
                ->where('assessment_status', 2)
                ->where('assessment_start >=', date('Y-m-d H:i:s'))
                ->where('assessment_end <=', date('Y-m-d H:i:s'))
                ->where('assessment_school_id', userdata()['school_id'])
                ->where('assessment_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-ass'] == 4) {
            $get = $this->assessment
                ->where('assessment_status', 4)
                ->where('assessment_school_id', userdata()['school_id'])
                ->where('assessment_teacher_id', userdata()['id_profile'])
                ->findAll();
        }

        $data = [];
        foreach ($get as $k => $v) {
            $groups = '';
            foreach (json_decode($v['assessment_group']) as $key => $val) {
                $groups .= '<badge class="badge badge-info mx-1">'.$val->group.'</badge>';
            }
            
            $data[] = [
                'id' => $v['assessment_id'],
                'title' => $v['assessment_title'],
                'mapel' => $v['assessment_subject_name'],
                'period' => $v['assessment_start'].' - '.$v['assessment_end'],
                'group' => $groups,
                'task' => $v['assessment_question_bank_title'],
            ];
        }

        echo (json_encode($data));
    }


}

