<?php

namespace App\Controllers\LearningMS\Tasks;

use App\Controllers\BaseController;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\Tasks\TasksModel;

class Tasks extends BaseController
{
    protected $title;
    protected $page;
    protected $teacher_subject;
    protected $teacher;
    protected $subject;
    protected $lesson_standart;
    protected $lesson_additional;
    protected $lesson_public;
    protected $tasks;

    public function __construct()
    {
        $this->title = "Tugas";
        $this->page = "Tasks";
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->lesson_standart = new StandartLessonModel();
        $this->lesson_additional = new AdditionalLessonModel();
        $this->lesson_public = new PublicLessonModel();
        $this->tasks = new TasksModel();
    }

    public function index()
    {
        $data["title"] = 'Tambah Tugas';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Add_Tasks';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Tambah Tugas',
        ];

        $te_duty = $this->teacher_subject->get_teacher_duty(userdata()['id_profile']);

        $list_grade = get_list('grade')[school_level(userdata()['school_id'])];
        $grade = $group = $subs = $sub = [];
        foreach ($te_duty as $k => $v) {
            $sub[$v['subject_id']] = $v['subject_name'];

            $subs[$v['subject_id']]['subjs'] = $v['subject_name'];
            $subs[$v['subject_id']]['subjs_id'] = $v['subject_id'];
            $subs[$v['subject_id']]['grade'][$v['student_group_grade']] = 'Kelas '.$list_grade[$v['student_group_grade']];


            $group[$v['student_group_id']] = $v['student_group_name'];
            $grade[$v['student_group_grade']]['grade'] = 'Kelas '.$list_grade[$v['student_group_grade']];
            $grade[$v['student_group_grade']]['subjs'][$v['subject_id']] = $v['subject_name'];
        }

        $data['sub'] = $sub;
        $data['grd'] = $list_grade;

        $data['my_duty'] = $subs;

        return view("learningms/tasks/index", $data);
    }

    public function grab_data_lesson()
    {
        $req = $this->request->getVar();
  
        $result = '';
        if ($req['type'] == 1) {
            $grade = $req['grad'];
            $subject = $req['subj'];
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
                        lesson_additional_id lesson_id,
                        lesson_additional_chapter as chapter,
                        lesson_additional_subchapter as text,
                        lesson_additional_subject_id as subject,
                        lesson_additional_grade as grade,
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
                        lesson_standart_id lesson_id,
                        lesson_standart_chapter as chapter,
                        lesson_standart_subchapter as text,
                        lesson_standart_subject_id as subject,
                        lesson_standart_grade as grade,
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
                        lesson_additional_id lesson_id,
                        lesson_additional_chapter as chapter,
                        lesson_additional_subchapter as text,
                        lesson_additional_subject_id as subject,
                        lesson_additional_grade as grade,
                    ')
                    ->where('lesson_additional_chapter', $v['text'])
                    ->where('lesson_additional_subchapter != ""')
                    ->where('lesson_additional_status < 9')
                    ->findAll();

                $public[$k]['nodes'] = $sub_chapter;
            }

            $result = [
                'subjname' => subject_rowid($req['subj'])['subject_name'],
                'gradname' => get_list('grade')[school_level(userdata()['school_id'])][$req['grad']],
                'datas' => array(
                    array('nodes' => $private, 'text' => 'Materi Saya', 'ind' => 1),
                    array('nodes' => $standard, 'text' => 'Materi Standar', 'ind' => 2),
                    array('nodes' => $public, 'text' => 'Materi Publik', 'ind' => 3),
                )
                ];

            
        } else if ($req['type'] == 2) {

            if ($req['param'] == 2) {
                $data = $this->lesson_standart
                    ->where('lesson_standart_id', $req['id'])
                    ->where('lesson_standart_status < 9')
                    ->first();
            } else {
                $data = $this->lesson_additional
                    ->select('
                        lesson_additional_id as lesson_standart_id,
                        lesson_additional_subject_id as lesson_standart_subject_id,
                        lesson_additional_grade as lesson_standart_grade,
                        lesson_additional_chapter as lesson_standart_chapter,
                        lesson_additional_subchapter as lesson_standart_subchapter,
                        lesson_additional_content as lesson_standart_content,
                        lesson_additional_content_path as lesson_standart_content_path,
                        lesson_additional_video_path as lesson_standart_video_path,
                        lesson_additional_attachment_path as lesson_standart_attachment_path,
                        lesson_additional_tasks as lesson_standart_tasks,
                    ')
                    ->where('lesson_additional_id', $req['id'])
                    ->where('lesson_additional_status < 9')
                    ->first();

            }

            $tasks = json_decode($data['lesson_standart_tasks']);
            $data['tasks'] = $tasks ? (array)$tasks : [];
            $data['attach_arr'] = $data['lesson_standart_attachment_path'] != '' ? array_values(json_decode($data['lesson_standart_attachment_path'], true)) : [];

            $result = $data;
        }

        echo json_encode($result);
    }

    public function store_data()
    {
        $req = $this->request->getVar();
        
        if ($req['type'] == 1) {
            $r = json_decode($req['param']);
            
            $group = [];
            foreach ($r[3] as $k => $v) {
                $group[$k]['id'] = $v->id; 
                $group[$k]['group'] = $v->text; 
            }
            
            $lsrc = null;
            if ($r[11] == 2) {
                $lsrc = $this->lesson_standart
                    ->select('lesson_standart_tasks as tasks')
                    ->where('lesson_standart_id', $r[8])
                    ->where('lesson_standart_status < 9')
                    ->first();
            } else {
                $lsrc = $this->lesson_additional
                    ->select('lesson_additional_tasks as tasks')
                    ->where('lesson_additional_id', $r[8])
                    ->where('lesson_additional_status < 9')
                    ->first();
            }

            $data = [
                'task_school_id' => userdata()['school_id'],
                'task_teacher_id' => userdata()['id_profile'],
                'task_grade' => $r[2],
                'task_subject_id' => $r[1],
                'task_subject_name' => $r[10],
                'task_group' => json_encode($group),
                'task_title' => $r[0],
                'task_lesson_id' => $r[8],
                'task_lesson_name' => $r[9],
                'task_lesson_src' => $r[11],
                'task_task_ids' => $lsrc['tasks'],
                'task_start' => date('Y-m-d H:i:s', strtotime($r[4].':00')),
                'task_end' => date('Y-m-d H:i:s', strtotime($r[5].':00')),
                'task_is_autosubmit' => $r[6],
                'task_instruction' => $r[7],
                'task_status' => $r[12],
            ];

            $ins = $this->tasks->insert($data);
            $res = [
                'typ' => $req['type'],
                'sts' => $ins,
                'msg' => $ins ? 'Tugas berhasil ditambahkan' : 'Tugas gagal ditambahkan',
                'icn' => $ins ? 'success' : 'error',
            ];
            echo json_encode($res);
        } else if ($req['type'] == 2) {
            $upd = $this->tasks
                ->where('task_id', $req['param'])
                ->set('task_status', $req['id'])
                ->update();

            $res = [
                'typ' => $req['type'],
                'sts' => $upd,
                'msg' => $upd ? 'Penilaian berhasil di terbitkan' : 'Penilaian gagal di terbitkan',
                'icn' => $upd ? 'success' : 'error',
            ];
            echo json_encode($res);
        }
    }

    public function index_draft()
    {
        $data["title"] = 'Draft';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Draft_Tasks';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Draft',
        ];

        return view("learningms/tasks/draft", $data);
    }

    public function index_scheduled()
    {
        $data["title"] = 'Terjadwal';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Scheduled_Tasks';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Terjadwal',
        ];

        return view("learningms/tasks/scheduled", $data);
    }

    public function index_present()
    {
        $data["title"] = 'Saat Ini';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Present_Tasks';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Saat Ini',
        ];

        return view("learningms/tasks/present", $data);
    }

    public function index_done()
    {
        $data["title"] = 'Selesai';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Done_Tasks';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        return view("learningms/tasks/done", $data);
    }

    public function list_tasks()
    {
        $req = $this->request->getVar();

        if ($req['page-ass'] == 1) {
            $get = $this->tasks
                ->where('task_status', 1)
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->orderBy('task_id', 'desc')
                ->findAll();
        } else if ($req['page-ass'] == 2) {
            $get = $this->tasks
                ->where('task_status', 2)
                ->where('task_start >=', date('Y-m-d H:i:s'))
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-ass'] == 3) {
            $get = $this->tasks
                ->where('task_status', 2)
                ->where('task_start <=', date('Y-m-d H:i:s'))
                ->where('task_end >=', date('Y-m-d H:i:s'))
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->findAll();
            } else if ($req['page-ass'] == 4) {
                $get = $this->tasks
                ->where('task_status', 2)
                ->where('task_end <=', date('Y-m-d H:i:s'))
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->findAll();
        }

        $data = [];
        foreach ($get as $k => $v) {
            $groups = '';
            foreach (json_decode($v['task_group']) as $key => $val) {
                $groups .= '<badge class="badge badge-info mx-1">'.$val->group.'</badge>';
            }
            
            $acts = '';
            if ($req['page-ass'] == 1) {
                if ($v['task_end'] < date('Y-m-d H:i:s')) {
                    $acts .= '
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" type="button" class="btn btn-sm btn-icon btn-danger" onclick="type_tasks(2, '.$v['task_id'].', 1)">
                        <i class="bi bi-trash-fill fs-1"></i>
                        </button>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah" type="button" class="btn btn-sm btn-icon btn-warning" onclick="edit_draft('.$v['task_id'].')"><i class="bi bi-pencil-square fs-1"></i></button>
                    ';
                } else {
                    $acts .= '
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim" type="button" class="btn btn-sm btn-icon btn-primary" onclick="type_tasks(2, '.$v['task_id'].', 2)">
                        <svg width="20" height="20" fill="currentColor" class="bi bi-send-check-fill" viewBox="0 0 16 16">
                        <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 1.59 2.498C8 14 8 13 8 12.5a4.5 4.5 0 0 1 5.026-4.47zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                        <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686"/>
                        </svg>
                        </button>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah" type="button" class="btn btn-sm btn-icon btn-warning" onclick="edit_draft('.$v['task_id'].')"><i class="bi bi-pencil-square fs-1"></i></button>
                    ';
                }
            } elseif ($req['page-ass'] == 2) {
                $acts .= '
                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Ubah ke Draft" type="button" class="btn btn-sm btn-icon btn-secondary" onclick="type_tasks(2, '.$v['task_id'].', 1)">
                    <i class="bi bi-backspace-fill fs-1"></i></button>
                ';
            }
            
            $data[] = [
                'id' => $v['task_id'],
                'title' => $v['task_title'],
                'mapel' => $v['task_subject_name'],
                'period' => $v['task_start'].' - '.$v['task_end'],
                'group' => $groups,
                'acts' => $acts,
            ];
        }

        echo (json_encode($data));
    }


}  