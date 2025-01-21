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

    public function first_page()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 1) {
            $teacher_id = userdata()['id_profile'];
            $subject_id = teacher_subjects($teacher_id);
            $grade = teacher_grades($teacher_id);

            $data = $this->public_question_bank->get_shared_qb($teacher_id, $subject_id, $grade);

            $pub = [];
            foreach ($data as $k => $v) {
                $pub[$v['question_bank_subject_id']]['question'] = $v['qb_total'];
                $pub[$v['question_bank_subject_id']]['subject_name'] = $v['subject_name'];
                $pub[$v['question_bank_subject_id']]['subject_id'] = $v['question_bank_subject_id'];
                $pub[$v['question_bank_subject_id']]['teacher'][$v['teacher_id']] = $v['teacher_id'];
            }

            echo json_encode($pub);
        }

    }

    public function quest_list()
    {
        $req = $this->request->getVar();
        

        $teacher_id = userdata()['id_profile'];
        $subject_id = [$req['subject_id']];
        $grade = teacher_grades($teacher_id);
        
        $data = $this->public_question_bank->get_shared_qb_list($teacher_id, $subject_id, $grade);

        $list = [];
        foreach ($data as $k => $v) {
            $deg = $v['teacher_degree'] != '' ? ' ,' . $v['teacher_degree'] : '';
            $lists = '
                <div class="d-flex justify-content-between rounded">
                    <div class="d-flex align-items-start">
                        <a href="'.base_url('teacher/question-bank/public/view-task/'.$v['question_bank_id'].'/'.$v['question_bank_title']).'" class="btn btn-primary pl-10">Lihat Soal</a>
                        <div class="flex-grow-1 me-2 mx-10">
                            <h3 class="mb-1">'.$v['question_bank_title'].'</h3>
                            <span class="text-gray-700 fw-semibold d-block">Total Soal: '.$v['qb_total'].'</span>
                        </div>
                    </div>

                    <div class="additional-info">
                        <div class="d-flex align-items-end flex-column">
                            <badge class="badge badge-info badge-block mb-1">'.grade_label($v['question_bank_grade']).'</badge>
                            <span class="text-gray-700 fw-semibold d-block">Dibagikan oleh: '.$v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg.' </span>
                        </div>
                    </div>
                </div>
            ';

            $list[] = [
                'id' => $v['question_bank_id'],
                'lists' => $lists
            ];
        }

        echo (json_encode($list));
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