<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;

class AdditionalQuestionBank extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $teacher_subject;
    protected $question_bank;
    protected $teacher;
    protected $subject;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Additional";
        $this->question_bank = new QuestionBankModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
    }

    public function index()
    {
        $data["title"] = 'Bank Soal Saya';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Bank Soal Saya',
        ];

        $data['subjects'] = $this->teacher_subject
            ->select('teacher_assign_id, subject_id, student_group_grade, student_group_name, subject_name')
            ->join('master_student_group', 'student_group_id=teacher_assign_student_group_id')
            ->join('master_subject', 'subject_id=teacher_assign_subject_id')
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->where('teacher_assign_status < 9')
            ->groupBy('student_group_grade')
            ->findAll();

        return view("learningms/question_bank_additional/index", $data);
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

    public function share_task()
    {
        $req = $this->request->getVar();
        $shared_to = '';
        if ($req['val'] == 4) {
            $shared_to = isset($req['thc']) != '' ? json_encode($req['thc']) : '';
        } 

        $share = $this->question_bank
            ->where('question_bank_id', $req['idd'])
            ->set('question_bank_shared_type', $req['val'])
            ->set('question_bank_shared_to', $shared_to)
            ->update();

        echo json_encode($share);
    }

    public function get_question()
    {
        $req = $this->request->getVar();
        $d = $this->question_bank
            ->where('question_bank_id', $req['id'])
            ->first();

        $opt = json_decode($d['question_bank_option']);
        $ans = json_decode($d['question_bank_answer']);

        foreach ($ans as $k => $v) {
            $key = array_search($v, $opt);
            $opt['r_' . $k] = $opt[$key];
            unset($opt[$key]);
        }

        $res = [
            'id' => $d['question_bank_id'],
            'parent' => $d['question_bank_parent_id'],
            'subj' => $d['question_bank_subject_id'],
            'grad' => $d['question_bank_grade'],
            'title' => $d['question_bank_title'],
            'poin' => $d['question_bank_poin'],
            'type' => $d['question_bank_type'],
            'question' => $d['question_bank_question'],
            'option' => $opt,
            'explain' => $d['question_bank_explain'],
            'hint' => $d['question_bank_hint'],
            'list_quest' => get_list('question_type'),
        ];

        echo json_encode($res);
    }

    public function update_content() 
    {
        $req = $this->request->getVar();

        $update = false;
        if($req['type'] == 1) {
            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $req['val'][1],
                'question_bank_grade' => $req['val'][2],
                'question_bank_title' => htmlspecialchars($req['val'][0]),
                'question_bank_status' => 1
            ];

            $update = $this->question_bank->insert($ins);

        } else if ($req['type'] == 2) {
            $update = $this->question_bank
                ->set('question_bank_title', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();
        } else if ($req['type'] == -1) {

            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $req['val'][0],
                'question_bank_grade' => $req['val'][1],
                'question_bank_type' => $req['val'][2],
                'question_bank_question' => $req['val'][3],
                'question_bank_option' => $req['val'][4],
                'question_bank_answer' => $req['val'][5],
                'question_bank_poin' => $req['val'][6],
                'question_bank_hint' => $req['val'][7],
                'question_bank_explain' => $req['val'][8],
                'question_bank_parent_id' => $req['id'],
                'question_bank_status' => 1
            ];

            $update = $this->question_bank->insert($ins);
        } else if ($req['type'] == -11) {

            $update = $this->question_bank
                ->set('question_bank_type', $req['val'][2])
                ->set('question_bank_question', $req['val'][3])
                ->set('question_bank_option', $req['val'][4])
                ->set('question_bank_answer', $req['val'][5])
                ->set('question_bank_poin', $req['val'][6])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

        } else if ($req['type'] == -12) {
            $update = $this->question_bank
                ->set('question_bank_hint', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

        } else if ($req['type'] == -13) {
            $update = $this->question_bank
                ->set('question_bank_explain', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

        } else if ($req['type'] == -14) {
            $update = $this->question_bank
                ->set('question_bank_parent_id', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

        } else if ($req['type'] == -15) {
            $d = $this->question_bank->where('question_bank_id', $req['id'])->first();

            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $d['question_bank_subject_id'],
                'question_bank_grade' => $d['question_bank_grade'],
                'question_bank_type' => $d['question_bank_type'],
                'question_bank_question' => $d['question_bank_question'],
                'question_bank_option' => $d['question_bank_option'],
                'question_bank_answer' => $d['question_bank_answer'],
                'question_bank_poin' => $d['question_bank_poin'],
                'question_bank_hint' => $d['question_bank_hint'],
                'question_bank_explain' => $d['question_bank_explain'],
                'question_bank_parent_id' => $req['val'][0],
                'question_bank_status' => 1
            ];

            $update = $this->question_bank->insert($ins);
        }
        
        echo json_encode($update);
    

    }

    public function remove_content()
    {
        $req = $this->request->getVar();

        $remove = false;
        if ($req['type'] == 1) {
            $remove = $this->question_bank
                ->set('question_bank_status', 9)
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();
        } else if ($req['type'] == 2) {
            $remove = $this->question_bank
                ->set('question_bank_status', 9)
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();
        } else if ($req['type'] == 3) {
            $remove = $this->question_bank
                ->set('question_bank_hint', '<p><br></p>')
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();
        } else if ($req['type'] == 4) {
            $remove = $this->question_bank
                ->set('question_bank_explain', '<p><br></p>')
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();
        }
        
        echo json_encode($remove);
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
            ->where('question_bank_id <> '. $req['parent'])
            ->findAll();

        echo json_encode($question);
    }

}