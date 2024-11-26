<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\AdditionalQuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;

class PublicQuestionBank extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $teacher_subject;
    protected $question_bank_additional;
    protected $teacher;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Public";
        $this->question_bank_additional = new AdditionalQuestionBankModel();
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

        $data['subjects'] = $this->teacher_subject
            ->select('teacher_assign_id, subject_id, student_group_grade, student_group_name, subject_name')
            ->join('master_student_group', 'student_group_id=teacher_assign_student_group_id')
            ->join('master_subject', 'subject_id=teacher_assign_subject_id')
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->where('teacher_assign_status < 9')
            ->groupBy('student_group_grade')
            ->findAll();

        return view("learningms/question_bank_public/index", $data);
    }

}