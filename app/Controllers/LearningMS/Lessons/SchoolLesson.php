<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\SchoolLessonModel;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\Systems\TeacherAssignModel;

class SchoolLesson extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $lesson_school;
    protected $lesson_standart;
    protected $lesson_additional;
    protected $lesson_public;
    protected $teacher_subject;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->sidebar = "School";
        $this->lesson_school = new SchoolLessonModel();
        $this->lesson_standart = new StandartLessonModel();
        $this->lesson_additional = new AdditionalLessonModel();
        $this->lesson_public = new PublicLessonModel();
        $this->teacher_subject = new TeacherAssignModel();
    }

    public function index()
    {
        $data["title"] = "Materi Sekolah";
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Tambahan',
        ];

        $data['subjects'] = $this->teacher_subject
        ->select('teacher_assign_id, subject_id, student_group_grade, student_group_name, subject_name')
        ->join('master_student_group', 'student_group_id=teacher_assign_student_group_id')
        ->join('master_subject', 'subject_id=teacher_assign_subject_id')
        ->where('teacher_assign_teacher_id', userdata()['id_profile'])
        ->where('teacher_assign_status < 9')
        ->groupBy('student_group_grade')
        ->findAll();


        return view("learningms/lesson_school/index", $data);
    }

    public function view_content($subject, $grade)
    {
        $data["title"] = 'Materi Belajar';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/school' => 'Materi Tambahan',
            '##' => 'Materi Belajar',
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $chapter = $this->lesson_school
            ->select('
                lesson_school_id, 
                lesson_school_chapter, 
                lesson_school_lesson_additional_id, 
                lesson_school_lesson_standart_id,
                lesson_school_lesson_shared_id
            ')
            ->where('lesson_school_teacher_id', userdata()['id_profile'])
            ->where('lesson_school_status < 9')
            ->where('lesson_school_subject_id', $subject)
            ->where('lesson_school_grade', $grade)
            ->groupBy('
                lesson_school_chapter
            ')
            ->findAll();

        foreach ($chapter as $k => $v) {
            $sub_chapter = '';
            if ($v['lesson_school_lesson_additional_id'] > 0) {
                $chaps = $this->lesson_additional->where('lesson_additional_id', $v['lesson_school_lesson_additional_id'])->first();
                $sub_chapter = array();
                if (!empty($chaps)) {
                    $sub_chapter = $this->lesson_additional
                        ->select('
                            lesson_additional_id,
                            0 as lesson_standart_id,
                            lesson_additional_subchapter as lesson_subchapter,
                            lesson_additional_content as lesson_content,
                            lesson_additional_content_path as lesson_content_path,
                            lesson_additional_video_path as lesson_video_path,
                            lesson_additional_attachment_path as lesson_attachment_path,
                            lesson_additional_tasks as lesson_task,
                            "additional" as lesson_source,
                        ')
                        ->join('lms_lesson_school', 'lesson_school_lesson_additional_id=lesson_additional_id')
                        ->where('lesson_additional_chapter', $chaps['lesson_additional_chapter'])
                        ->where('lesson_additional_status < 9')
                        ->findAll();
                }
            } else if ($v['lesson_school_lesson_standart_id'] > 0) {
                $chaps = $this->lesson_standart->where('lesson_standart_id', $v['lesson_school_lesson_standart_id'])->first();
                $sub_chapter = array();
                if (!empty($chaps)) {
                    $sub_chapter = $this->lesson_standart
                        ->select('
                            0 as lesson_additional_id,
                            lesson_standart_id,
                            lesson_standart_subchapter as lesson_subchapter,
                            lesson_standart_content as lesson_content,
                            lesson_standart_content_path as lesson_content_path,
                            lesson_standart_video_path as lesson_video_path,
                            lesson_standart_attachment_path as lesson_attachment_path,
                            lesson_standart_tasks as lesson_task,
                            "standard" as lesson_source,
                        ')
                        ->join('lms_lesson_school', 'lesson_school_lesson_standart_id=lesson_standart_id')
                        ->where('lesson_standart_chapter', $chaps['lesson_standart_chapter'])
                        ->where('lesson_standart_status < 9')
                        ->findAll();
                }
            } else {
                $chaps = $this->lesson_additional->where('lesson_additional_id', $v['lesson_school_lesson_shared_id'])->first();
                $sub_chapter = array();
                if (!empty($chaps)) {
                    $sub_chapter = $this->lesson_additional
                        ->select('
                            lesson_additional_id,
                            0 as lesson_standart_id,
                            lesson_additional_subchapter as lesson_subchapter,
                            lesson_additional_content as lesson_content,
                            lesson_additional_content_path as lesson_content_path,
                            lesson_additional_video_path as lesson_video_path,
                            lesson_additional_attachment_path as lesson_attachment_path,
                            lesson_additional_tasks as lesson_task,
                            "additional" as lesson_source,
                        ')
                        ->join('lms_lesson_school', 'lesson_school_lesson_shared_id=lesson_additional_id')
                        ->where('lesson_additional_chapter', $chaps['lesson_additional_chapter'])
                        ->where('lesson_additional_status < 9')
                        ->findAll();
                }
            }

            $chapter[$k]['sub_chapter'] = $sub_chapter;
        }

        $data['chapters'] = $chapter;

        return view("learningms/lesson_school/content", $data);
    }

    
    public function grab_content()
    {
        $id = $this->request->getVar('id');
        $source = $this->request->getVar('source');
        $data = '';
        if ($source == 'additional') {
            $data = $this->lesson_additional
                ->select('
                    lesson_additional_content as lesson_content,
                    lesson_additional_content_path as lesson_content_path,
                    lesson_additional_video_path as lesson_video_path,
                    lesson_additional_attachment_path as lesson_attachment_path,
                    lesson_additional_tasks as lesson_task
                ')
                ->where('lesson_additional_id', $id)
                ->where('lesson_additional_status < 9')
                ->first();
        } else {
            $data = $this->lesson_standart
                ->select('
                    lesson_standart_content as lesson_content,
                    lesson_standart_content_path as lesson_content_path,
                    lesson_standart_video_path as lesson_video_path,
                    lesson_standart_attachment_path as lesson_attachment_path,
                    lesson_standart_tasks as lesson_task
                ')
                ->where('lesson_standart_id', $id)
                ->where('lesson_standart_status < 9')
                ->first();
        }
            
        echo json_encode($data);
    }

    public function update_content()
    {
        $req = $this->request->getVar();

        $update = false;
        if ($req['type'] == 1) {
            $update = $this->lesson_school
                ->set('lesson_school_chapter', $req['val'][0])
                ->set('lesson_school_updated_by', userdata()['user_id'])
                ->where('lesson_school_chapter', $req['id'])
                ->update();
        } elseif ($req['type'] == 2) {
            $update = $this->lesson_school
                ->set('lesson_school_chapter', $req['val'][0])
                ->set('lesson_school_subchapter', $req['val'][1])
                ->set('lesson_school_updated_by', userdata()['user_id'])
                ->where('lesson_school_id', $req['id'])
                ->update();
        } elseif ($req['type'] == 3) {
            $arr_ins = [
                'lesson_school_school_id' => userdata()['school_id'],
                'lesson_school_teacher_id' => userdata()['id_profile'],
                'lesson_school_subject_id' => $req['val'][1],
                'lesson_school_grade' => $req['val'][2],
                'lesson_school_chapter' => htmlspecialchars($req['val'][0]),
                'lesson_school_subchapter' => htmlspecialchars($req['val'][3]),
                'lesson_school_created_by' => userdata()['user_id'],
                'lesson_school_status' => 1,
            ];

            $update = $this->lesson_school->insert($arr_ins);
        } elseif ($req['type'] == 4) {
            $arr_ins = [
                'lesson_school_school_id' => userdata()['school_id'],
                'lesson_school_school_year_id' => year_active()['school_year_id'],
                'lesson_school_teacher_id' => userdata()['id_profile'],
                'lesson_school_subject_id' => $req['val'][1],
                'lesson_school_grade' => $req['val'][2],
                'lesson_school_chapter' => htmlspecialchars($req['val'][0]),
                'lesson_school_created_by' => userdata()['user_id'],
                'lesson_school_status' => 1,
            ];

            $update = $this->lesson_school->insert($arr_ins);
        }


        echo json_encode($update);
    }

    public function grab_all_subchap()
    {
        $id = $this->request->getVar('id');
        $sou = $this->lesson_school->where('lesson_school_id', $id)->first();
        $grade = $sou['lesson_school_grade'];
        $subject = $sou['lesson_school_subject_id'];
        $teacher = userdata()['id_profile'];
        $school = userdata()['school_id'];

        $private = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter as text')
            ->where('lesson_additional_school_id', $school)
            ->where('lesson_additional_teacher_id', $teacher)
            ->where('lesson_additional_grade', $grade)
            ->where('lesson_additional_subject_id', $subject)
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_subchapter != ""')
            ->findAll();

        foreach ($private as $k => $v) {
            $sub_chapter = '';
            $sub_chapter = $this->lesson_additional
                ->select('
                    lesson_additional_id,
                    lesson_additional_subchapter as text
                ')
                ->where('lesson_additional_chapter', $v['text'])
                ->where('lesson_additional_subchapter != ""')
                ->where('lesson_additional_status < 9')
                ->findAll();

            $private[$k]['nodes'] = $sub_chapter;
        }
        
        $standard = $this->lesson_standart
            ->select('lesson_standart_id, lesson_standart_chapter as text')
            ->where('lesson_standart_grade', $grade)
            ->where('lesson_standart_subject_id', $subject)
            ->where('lesson_standart_status < 9')
            ->where('lesson_standart_subchapter != ""')
            ->groupBy('lesson_standart_chapter')
            ->findAll();

        foreach ($standard as $k => $v) {
            $sub_chapter = '';
            $sub_chapter = $this->lesson_standart
                ->select('
                    lesson_standart_id,
                    lesson_standart_subchapter as text
                ')
                ->where('lesson_standart_chapter', $v['text'])
                ->where('lesson_standart_subchapter != ""')
                ->where('lesson_standart_status < 9')
                ->findAll();

            $standard[$k]['nodes'] = $sub_chapter;
        }

        $public_temp = $this->lesson_public->get_shared($teacher, [$subject], [$grade]);
        $public = distinct_array($public_temp, 'lesson_additional_chapter');

        foreach ($public as $k => $v) {
            $sub_chapter = '';
            $sub_chapter = $this->lesson_additional
                ->select('
                    lesson_additional_id,
                    lesson_additional_subchapter as text
                ')
                ->where('lesson_additional_chapter', $v['text'])
                ->where('lesson_additional_subchapter != ""')
                ->where('lesson_additional_status < 9')
                ->findAll();

            $public[$k]['nodes'] = $sub_chapter;
        }
        $result = array(
            array('nodes' => $private, 'text' => 'Materi Saya'),
            array('nodes' => $standard, 'text' => 'Materi Standar'),
            array('nodes' => $public, 'text' => 'Materi Publik'),
        );

        echo json_encode($result);
    }
}