<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\Profiles\TeacherModel;


class PublicLesson extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $standart_lesson;
    protected $lesson_additional;
    protected $lesson_public;
    protected $teacher;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->page = "Lesson";
        $this->sidebar = "Public";
        $this->standart_lesson = new StandartLessonModel();
        $this->lesson_additional = new AdditionalLessonModel();
        $this->lesson_public = new PublicLessonModel();
        $this->teacher = new TeacherModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Publik',
        ];

        // $teacher_id = userdata()['id_profile'];
        // $subject_id = teacher_subjects($teacher_id);
        // $grade = teacher_grades($teacher_id);

        // $data['shared'] = $this->lesson_public->get_shared($teacher_id, $subject_id, $grade);

        return view("learningms/lesson_public/index", $data);
    }

    public function first_page()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 1) {
            $teacher_id = userdata()['id_profile'];
            $subject_id = teacher_subjects($teacher_id);
            $grade = teacher_grades($teacher_id);

            $data = $this->lesson_public->get_shared($teacher_id, $subject_id, $grade);
            
            $pub = [];
            foreach ($data as $k => $v) {
                // $deg = $v['teacher_degree'] != '' ? ' ,' . $v['teacher_degree'] : '';
                // $pub[$v['lesson_additional_subject_id']]['teacher_name'] = $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg;

                $pub[$v['lesson_additional_subject_id']]['subject_name'] = $v['subject_name'];
                $pub[$v['lesson_additional_subject_id']]['subject_id'] = $v['lesson_additional_subject_id'];
                $pub[$v['lesson_additional_subject_id']]['chapter'][$v['lesson_additional_chapter']] = $v['lesson_additional_chapter'];
                $pub[$v['lesson_additional_subject_id']]['subchapter'][$v['lesson_additional_subchapter']] = $v['lesson_additional_subchapter'];
            }

            echo json_encode($pub);
        }
    }

    public function lesson_list()
    {
        $req = $this->request->getVar();

        $teacher_id = userdata()['id_profile'];
        $subject_id = [$req['subject_id']];
        $grade = teacher_grades($teacher_id);
        
        $data = $this->lesson_public->get_shared_list($teacher_id, $subject_id, $grade);

        $list = [];
        foreach ($data as $k => $v) {
            $deg = $v['teacher_degree'] != '' ? ' ,' . $v['teacher_degree'] : '';
            $lists = '
                <div class="d-flex justify-content-between rounded">
                    <div class="d-flex align-items-start">
                        <a href="'.base_url('teacher/lesson/public/view-content/'.$v['lesson_additional_id']).'" class="btn btn-primary pl-10">Lihat Materi</a>
                        <div class="flex-grow-1 me-2 mx-10">
                            <h3 class="mb-1">'.$v['lesson_additional_subchapter'].'</h3>
                            <span class="text-gray-700 fw-semibold d-block">BAB: '.$v['lesson_additional_chapter'].'</span>
                        </div>
                    </div>

                    <div class="additional-info">
                        <div class="d-flex align-items-end flex-column">
                            <badge class="badge badge-info badge-block mb-1">'.grade_label($v['lesson_additional_grade']).'</badge>
                            <span class="text-gray-700 fw-semibold d-block">Dibagikan oleh: '.$v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg.' </span>
                        </div>
                    </div>
                </div>
            ';

            $list[] = [
                'id' => $v['lesson_additional_id'],
                'lists' => $lists
            ];
        }

        // echo '<pre>';
        // print_r($list);
        // echo '</pre>';
        // die;

        echo (json_encode($list));
    }

    public function view_content($id)
    {
        $data["title"] = $this->title;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;

        $dt = $this->lesson_additional
            ->where('lesson_additional_id', $id)
            ->first();

        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/public' => 'Materi Publik',
            '###' => $dt['lesson_additional_chapter'],
            '####' => $dt['lesson_additional_subchapter']
        ];


        session()->setFlashdata('id_content', $id);

        return view("learningms/lesson_public/content", $data);
    }

    public function get_content()
    {
        $id = $this->request->getVar('id');

        $chapter = $this->lesson_additional
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_id', $id)
            ->groupBy('lesson_additional_chapter')
            ->first();

        $tasks = json_decode($chapter['lesson_additional_tasks']);

        $chapter['tasks'] = $tasks ? (array)$tasks : [];
        $chapter['attach_arr'] = $chapter['lesson_additional_attachment_path'] != '' ? array_values(json_decode($chapter['lesson_additional_attachment_path'], true)) : [];

        echo json_encode($chapter);
    }
}
