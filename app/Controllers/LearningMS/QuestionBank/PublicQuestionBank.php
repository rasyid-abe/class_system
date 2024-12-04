<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\PublicQuestionBankModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;

class PublicQuestionBank extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $teacher_subject;
    protected $public_question_bank;
    protected $question_bank;
    protected $teacher;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Public";
        $this->public_question_bank = new PublicQuestionBankModel();
        $this->question_bank = new QuestionBankModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
    }

    public function index()
    {
        $data["title"] = 'Bank Soal Publik';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Bank Soal Publik',
        ];

        $teacher_id = userdata()['id_profile'];
        $subject_id = teacher_subjects($teacher_id);
        $grade = teacher_grades($teacher_id);

        $data['shared'] = $this->public_question_bank->get_shared($teacher_id, $subject_id, $grade);

        return view("learningms/question_bank_public/index", $data);
    }

    public function view_task($id,$title) 
    {
        $data["title"] = 'Soal ' .$title;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;

        $dt = $this->question_bank
            ->select('question_bank_id')
            ->where('question_bank_parent_id', $id)
            ->findAll();
        
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/question-bank/public' => 'Bank Soal Publik',
            '###' => 'Soal ' .$title,
        ];

        $data['quest'] = array_chunk($dt, 5);

        return view("learningms/question_bank_public/content", $data);
    }

}