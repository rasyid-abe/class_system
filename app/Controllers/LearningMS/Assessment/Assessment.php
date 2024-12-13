<?php

namespace App\Controllers\LearningMS\Assessment;

use App\Controllers\BaseController;
use App\Models\QuestionBank\QuestionBankModel;
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
    protected $teacher;
    protected $subject;
    protected $assessment;

    public function __construct()
    {
        $this->title = "Penilaian";
        $this->page = "Assessment";
        $this->sidebar = "Draft_Assessment";
        $this->question_bank = new QuestionBankModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->assessment = new AssessmentModel();
    }

    public function index()
    {
        $data["title"] = 'Tambah Penilaian';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Tambah Penilaian',
        ];

        $te_duty = $this->teacher_subject->get_teacher_duty(userdata()['id_profile']);

        $list_grade = get_list('grade')[school_level(userdata()['school_id'])];
        $grade = $group = $subs = [];
        foreach ($te_duty as $k => $v) {
            $subs[$v['subject_id']] = $v['subject_name'];
            $group[$v['student_group_id']] = $v['student_group_name'];
            $grade[$v['student_group_grade']] = 'Kelas '.$list_grade[$v['student_group_grade']];
        }

        $data['subs'] = $subs;
        $data['grade'] = $grade;

        return view("learningms/assessment/index", $data);
    }

    public function group_exists()
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

    public function example_tabulator()
    {
        $dt = $this->question_bank
            ->select('
                question_bank_id as id,
                question_bank_question as name,
            ')
            ->findAll();
        $data = [
            ["id"=>1, "name"=>"Billy Bob", "progress"=>"12", "gender"=>"male", "height"=>1, "col"=>"red", "dob"=>"", "driver"=>1],
            ["id"=>2, "name"=>"Mary May", "progress"=>"1", "gender"=>"female", "height"=>2, "col"=>"blue", "dob"=>"14/05/1982", "driver"=>true],
            ["id"=>3, "name"=>"Christine Lobowski", "progress"=>"42", "height"=>0, "col"=>"green", "dob"=>"22/05/1982", "driver"=>"true"],
            ["id"=>4, "name"=>"Brendon Philips", "progress"=>"125", "gender"=>"male", "height"=>1, "col"=>"orange", "dob"=>"01/08/1980"],
            ["id"=>5, "name"=>"Margret Marmajuke", "progress"=>"16", "gender"=>"female", "height"=>5, "col"=>"yellow", "dob"=>"31/01/1999"],
        ];

        $dt_final = array_chunk($dt, 10);

        echo(json_encode($dt));
    }


}

