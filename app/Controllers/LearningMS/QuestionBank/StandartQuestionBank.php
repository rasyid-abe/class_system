<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use App\Models\Activities\ActivityModel;

class StandartQuestionBank extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $question_bank_standart;
    protected $question_bank;
    protected $teacher;
    protected $subject;
    protected $activity;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Standart";
        $this->question_bank_standart = new StandartQuestionBankModel();
        $this->question_bank = new QuestionBankModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->activity = new ActivityModel();
    }

    public function index()
    {
        $data["title"] = 'Bank Soal Standar';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Bank Soal Standart',
        ];

        return view("learningms/question_bank_standart/index", $data);
    }

    public function first_page()
    {
        $req = $this->request->getVar();
        
        $grades = list_grade(userdata()['school_id']);

        $ls = list_phase('phase');
        $phase = [];
        $grds = [];
        foreach ($grades as $k => $v) {
            $phase[] = $ls[$k];
            $grds[] = $k;
        }

        if($req['type'] == 1) {
            $total_title = $this->question_bank_standart
                ->select('count(question_bank_standart_id) as total')
                ->whereIn('question_bank_standart_phase', $phase)
                ->whereIn('question_bank_standart_grade', $grds)
                ->where('question_bank_standart_status < 9')
                ->where('question_bank_standart_parent_id', 0)
                ->first();

            $total_question = $this->question_bank_standart
                ->select('count(question_bank_standart_id) as total')
                ->whereIn('question_bank_standart_phase', $phase)
                ->whereIn('question_bank_standart_grade', $grds)
                ->where('question_bank_standart_status < 9')
                ->where('question_bank_standart_parent_id > 0')
                ->first();
            
            $grades = list_grade(userdata()['school_id']);
            
            $res = [
                't_title' => $total_title['total'],
                't_quest' => $total_question['total'],
                'grades' => $grades,
            ];

            echo json_encode($res);
            
        }
    }

    public function qb_list()
    {
        $req = $this->request->getVar();
        $subject = $this->question_bank_standart->list_first_page($req['grade']);

        $sub_list = [];
        foreach ($subject as $k => $v) {
            if ($v['parent'] < 1) {
                $sub_list[$v['subject_id']]['title'][$v['question_bank_standart_id']] = $v['title'];
            } else {
                $sub_list[$v['subject_id']]['quest_id'][$v['question_bank_standart_id']] = $v['question_bank_standart_id'];
            }
            $sub_list[$v['subject_id']]['subj_id'] = $v['subject_id'];
            $sub_list[$v['subject_id']]['grade'] = $req['grade'];
            $sub_list[$v['subject_id']]['subj'] = $v['subject_name'];
            $sub_list[$v['subject_id']]['qbid'] = $v['question_bank_standart_id'];
        }

        $data = [];
        foreach ($sub_list as $k => $v) {
            $ctitle = count($v['title']);
            $cquest = count($v['quest_id']);
            $lists = '
                <div class="d-flex justify-content-between rounded">
                    <div class="d-flex align-items-start">
                        <a href="'.base_url('teacher/question-bank/standart/view-content/'. $v['subj_id'] .'/'. $v['grade']).'" class="btn btn-primary pl-10">Lihat Soal</a>
                        <div class="flex-grow-1 me-2 mx-10">
                            <h3 class="mb-1">'.$v['subj'].'</h3>
                            <span class="text-gray-700 fw-semibold d-block">Judul Bank Soal: '.$ctitle.' | Total Soal: '.$cquest.'</span>
                        </div>
                    </div>

                    <div class="additional-info">
                        <div class="d-flex align-items-end flex-column">
                           
                        </div>
                    </div>
                </div>
            ';

            $data[] = [
                'id' => $v['subj_id'],
                'lists' => $lists
            ];
        }

        echo (json_encode($data));
    }

    public function view_subject($grade)
    {
        $data["title"] = 'Bank Soal Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/question-bank/standart/' => 'Bank Soal Standar',
            '##' => 'Kelas ' . $grade,
        ];

        $subs = $this->question_bank_standart->list_subject($grade);

        $data['subjects'] = $subs;

        return view("learningms/question_bank_standart/subject", $data);
    }

    public function view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'];
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/question-bank/standart' => 'Bank Soal Standar',
            '/teacher/question-bank/standart/view-subject/' . $grade => 'Kelas ' . $grade,
            '###' => $subs['subject_name'] ,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $question = $this->question_bank_standart
            ->select('question_bank_standart_id, question_bank_standart_title')
            ->where('question_bank_standart_status < 9')
            ->where('question_bank_standart_subject_id', $subject)
            ->where('question_bank_standart_grade', $grade)
            ->where('question_bank_standart_parent_id', 0)
            ->findAll();
        
        foreach ($question as $k => $v) {
            $child = $this->question_bank_standart
                ->select('question_bank_standart_id, question_bank_standart_parent_id')
                ->where('question_bank_standart_parent_id', $v['question_bank_standart_id'])
                ->where('question_bank_standart_status < 9')
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

        return view("learningms/question_bank_standart/content", $data);
    }

    public function get_question()
    {
        $req = $this->request->getVar();

        $teacher_grade = teacher_grades(userdata()['id_profile']);
        $teacher_subjects = teacher_subjects(userdata()['id_profile']);
        
        $d = $this->question_bank_standart
            ->where('question_bank_standart_id', $req['id'])
            ->first();

        $access = 0;
        if (
            $teacher_grade[0] == $d['question_bank_standart_grade'] && 
            in_array($d['question_bank_standart_subject_id'], $teacher_subjects)
        ) {
          $access = 1;  
        }

        $opt = $d['question_bank_standart_option'] != '' && $d['question_bank_standart_option'] != [] ? json_decode($d['question_bank_standart_option']) : [];
        $ans = $d['question_bank_standart_answer'] != '' && $d['question_bank_standart_answer'] != [] ? json_decode($d['question_bank_standart_answer']) : [];

        $idx_ans = [];
        foreach ($ans as $k => $v) {
            $idx_ans[] = array_search($v, $opt);
        }

        $res = [
            'id' => $d['question_bank_standart_id'],
            'parent' => $d['question_bank_standart_parent_id'],
            'subj' => $d['question_bank_standart_subject_id'],
            'grad' => $d['question_bank_standart_grade'],
            'title' => $d['question_bank_standart_title'],
            'poin' => $d['question_bank_standart_poin'],
            'type' => $d['question_bank_standart_type'],
            'keys' => $idx_ans,
            'question' => $d['question_bank_standart_question'],
            'option' => $opt,
            'explain' => $d['question_bank_standart_explain'],
            'hint' => $d['question_bank_standart_hint'],
            'list_quest' => get_list('question_type'),
            'access' => $access
        ];
        
        echo json_encode($res);
    }

    public function get_title_list()
    {
        $req = $this->request->getVar();
        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title')
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_status < 9')
            ->where('question_bank_subject_id', $req['subj'])
            ->where('question_bank_grade', $req['grad'])
            ->where('question_bank_parent_id', 0)
            ->findAll();

        echo json_encode($question);
    }

    public function update_content()
    {
        $req = $this->request->getVar();
        $d = $this->question_bank_standart->where('question_bank_standart_id', $req['id'])->first();

        $ins = [
            'question_bank_school_id' => userdata()['school_id'],
            'question_bank_teacher_id' => userdata()['id_profile'],
            'question_bank_subject_id' => $d['question_bank_standart_subject_id'],
            'question_bank_grade' => $d['question_bank_standart_grade'],
            'question_bank_type' => $d['question_bank_standart_type'],
            'question_bank_question' => $d['question_bank_standart_question'],
            'question_bank_option' => $d['question_bank_standart_option'],
            'question_bank_answer' => $d['question_bank_standart_answer'],
            'question_bank_poin' => $d['question_bank_standart_poin'],
            'question_bank_hint' => $d['question_bank_standart_hint'],
            'question_bank_explain' => $d['question_bank_standart_explain'],
            'question_bank_parent_id' => $req['val'][0],
            'question_bank_status' => 1,
            'question_bank_created_by' => 1
        ];

        $this->question_bank->insert($ins);
        $sts = $this->question_bank->error();
        if ($sts['code'] > 0) {
            logging('error', 'copy task failed : ' . $sts['message']);

            $res = [
                'head' => '',
                'msg' => 'Salin soal gagal.',
                'icon' => 'error',
                'collapse' => 0,
                'show_quest' => 0,
                'coll_act' => 0,
                'src' => $req['val'][2]
            ];
        } else {
            $this->activity->store_log('Bank Soal Standar', 'copy', 'salin soal dari "Bank Soal Standar" ke "Bank Soal Saya"');
            $res = [
                'head' => '',
                'msg' => 'Salin soal berhasil.',
                'icon' => 'success',
                'collapse' => 0,
                'show_quest' => 0,
                'coll_act' => 0,
                'src' => $req['val'][2]

            ];
        }

        echo json_encode($res);
    }
}