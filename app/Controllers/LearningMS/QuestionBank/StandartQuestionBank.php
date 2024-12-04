<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use Faker\Provider\ar_EG\Person;

class StandartQuestionBank extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $teacher_subject;
    protected $question_bank_standart;
    protected $teacher;
    protected $subject;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Standart";
        $this->question_bank_standart = new StandartQuestionBankModel();
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

        $grades = $this->teacher_subject
            ->select('teacher_assign_grade, count(teacher_assign_subject_id) as total_subject')
            ->where('teacher_assign_status < 9')
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->groupBy('teacher_assign_grade')
            ->findAll();

        $data['grades'] = $grades;

        return view("learningms/question_bank_standart/index", $data);
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
}