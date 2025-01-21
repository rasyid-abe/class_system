<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;

class StandartQuestionBank extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $teacher_subject;
    protected $question_bank_standart;
    protected $question_bank;
    protected $teacher;
    protected $subject;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Standart";
        $this->question_bank_standart = new StandartQuestionBankModel();
        $this->question_bank = new QuestionBankModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
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
        
        if($req['type'] == 1) {
            $total_title = $this->question_bank_standart
                ->select('question_bank_standart_id')
                ->where('question_bank_standart_status < 9')
                ->groupBy('question_bank_standart_subject_id, question_bank_standart_grade')
                ->findAll();
            $total_question = $this->question_bank_standart
                ->select('question_bank_standart_id')
                ->where('question_bank_standart_status < 9')
                ->groupBy('question_bank_standart_subject_id, question_bank_standart_title, question_bank_standart_grade')
                ->findAll();
            
            $grades = list_grade(userdata()['school_id']);
            
            $res = [
                't_title' => count($total_title),
                't_quest' => count($total_question),
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
                $sub_list[$v['subject_id']]['title'] = $v['title'];
            }
            $sub_list[$v['subject_id']]['subj_id'] = $v['subject_id'];
            $sub_list[$v['subject_id']]['grade'] = $req['grade'];
            $sub_list[$v['subject_id']]['subj'] = $v['subject_name'];
            $sub_list[$v['subject_id']]['qbid'] = $v['question_bank_standart_id'];
            $sub_list[$v['subject_id']]['quest_id'][$v['question_bank_standart_id']] = $v['question_bank_standart_id'];
        }

        $data = [];
        foreach ($sub_list as $k => $v) {
            $tquest = count($v['quest_id']) - 1;
            $lists = '
                <div class="d-flex justify-content-between rounded">
                    <div class="d-flex align-items-start">
                        <a href="'.base_url('teacher/question-bank/standart/view-content/'. $v['subj_id'] .'/'. $v['grade']).'" class="btn btn-primary pl-10">Lihat Soal</a>
                        <div class="flex-grow-1 me-2 mx-10">
                            <h3 class="mb-1">'.$v['title'].'</h3>
                            <span class="text-gray-700 fw-semibold d-block">Total Soal: '.$tquest.'</span>
                        </div>
                    </div>

                    <div class="additional-info">
                        <div class="d-flex align-items-end flex-column">
                            <badge class="badge badge-info badge-block mb-1">'.grade_label($v['grade']).'</badge>
                            <span class="text-gray-700 fw-semibold d-block">'.$v['subj'].'</span>
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
        $d = $this->question_bank_standart
            ->where('question_bank_standart_id', $req['id'])
            ->first();

        $opt = json_decode($d['question_bank_standart_option']);
        $ans = $d['question_bank_standart_answer'];
        $key = array_search($ans, $opt);

        $opt['right'] = $opt[$key];
        unset($opt[$key]);

        $res = [
            'id' => $d['question_bank_standart_id'],
            'parent' => $d['question_bank_standart_parent_id'],
            'subj' => $d['question_bank_standart_subject_id'],
            'grad' => $d['question_bank_standart_grade'],
            'title' => $d['question_bank_standart_title'],
            'poin' => $d['question_bank_standart_poin'],
            'type' => $d['question_bank_standart_type'],
            'question' => $d['question_bank_standart_question'],
            'option' => $opt,
            'explain' => $d['question_bank_standart_explain'],
            'hint' => $d['question_bank_standart_hint'],
            'list_quest' => get_list('question_type'),
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
            'question_bank_status' => 1
        ];

        $update = $this->question_bank->insert($ins);

        echo json_encode($update);
    }
}