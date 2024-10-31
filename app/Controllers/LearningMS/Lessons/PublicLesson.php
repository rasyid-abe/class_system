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
    protected $subtitle;
    protected $standart_lesson;
    protected $lesson_additional;
    protected $lesson_public;
    protected $teacher;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->subtitle = "Materi Publik";
        $this->standart_lesson = new StandartLessonModel();
        $this->lesson_additional = new AdditionalLessonModel();
        $this->lesson_public = new PublicLessonModel();
        $this->teacher = new TeacherModel();
    }

    public function index()
    {
        $data["title"] = $this->subtitle;
        $data["sidebar"] = 'Public';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => $this->subtitle,
        ];

        $teacher_id = userdata()['id_profile'];
        $subject_id = teacher_subjects($teacher_id);
        $grade = teacher_grades($teacher_id);

        $data['shared'] = $this->lesson_public->get_shared($teacher_id, $subject_id, $grade);

        return view("learningms/lesson_public/index", $data);
    }

    public function view_content($id)
    {
        $data["title"] = 'Materi Belajar';
        $data["sidebar"] = 'Public';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/additional' => 'Materi Tambahan',
            '##' => 'Materi Belajar',
        ];

        session()->setFlashdata('id_content', $id);

        // $chapter = $this->lesson_additional
        //     ->where('lesson_additional_status < 9')
        //     ->where('lesson_additional_id', $id)
        //     ->groupBy('lesson_additional_chapter')
        //     ->findAll();
            

        // $data['teachers'] = $this->teacher
        //     ->select('teacher_id, teacher_first_name, teacher_last_name, teacher_degree')
        //     ->where('teacher_school_id', userdata()['school_id'])
        //     ->findAll();

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
