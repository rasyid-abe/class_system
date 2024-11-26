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

        $teacher_id = userdata()['id_profile'];
        $subject_id = teacher_subjects($teacher_id);
        $grade = teacher_grades($teacher_id);

        $data['shared'] = $this->lesson_public->get_shared($teacher_id, $subject_id, $grade);

        return view("learningms/lesson_public/index", $data);
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
            ->findAll();

        echo json_encode($chapter);
    }
}
