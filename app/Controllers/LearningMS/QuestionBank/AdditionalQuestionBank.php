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

        $data['questions'] = $question;
        $data['quest_type'] = get_list('question_type');

        return view("learningms/question_bank_additional/content", $data);
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
        }
        
        echo json_encode($remove);
    }

}