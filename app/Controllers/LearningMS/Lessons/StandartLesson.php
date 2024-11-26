<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Masters\SubjectModel;
use App\Models\Systems\TeacherAssignModel;

class StandartLesson extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $subject;
    protected $lesson_standart;
    protected $teacher_assign;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->page = "Lesson";
        $this->sidebar = "Standart";
        $this->subject = new SubjectModel();
        $this->lesson_standart = new StandartLessonModel();
        $this->teacher_assign = new TeacherAssignModel();
    }

    public function index()
    {
        $data["title"] = 'Materi Standar';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Standar',
        ];

        $grades = $this->teacher_assign
            ->select('teacher_assign_grade, count(teacher_assign_subject_id) as total_subject')
            ->where('teacher_assign_status < 9')
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->groupBy('teacher_assign_grade')
            ->findAll();

        $data['grades'] = $grades;

        return view("learningms/lesson_standart/index", $data);
    }

    public function view_subject($grade)
    {
        $data["title"] = 'Materi Standar Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/standart/' => 'Materi Standar',
            '##' => 'Kelas ' . $grade,
        ];

        $subs = $this->lesson_standart->list_subject($grade);

        $data['subjects'] = $subs;

        return view("learningms/lesson_standart/subject", $data);
    }

    public function view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'] . ' - Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;

        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/standart' => 'Materi Standard',
            '##' => 'Kelas ' . $grade,
            '###' => $subs['subject_name']
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $chapter = $this->lesson_standart
            ->select('lesson_standart_id, lesson_standart_chapter')
            ->where('lesson_standart_status < 9')
            ->where('lesson_standart_subject_id', $subject)
            ->where('lesson_standart_grade', $grade)
            ->groupBy('lesson_standart_chapter')
            ->findAll();
            
        foreach ($chapter as $k => $v) {
            $sub_chapter = $this->lesson_standart
                ->where('lesson_standart_chapter', $v['lesson_standart_chapter'])
                ->where('lesson_standart_status < 9')
                ->findAll();

            $chapter[$k]['sub_chapter'] = $sub_chapter;
        }

        $data['chapters'] = $chapter;

        return view("learningms/lesson_standart/content", $data);
    }

    public function grab_content()
    {
        $id = $this->request->getVar('id');
        $data = $this->lesson_standart
            ->where('lesson_standart_id', $id)
            ->where('lesson_standart_status < 9')
            ->first();
            
        echo json_encode($data);
    }
}