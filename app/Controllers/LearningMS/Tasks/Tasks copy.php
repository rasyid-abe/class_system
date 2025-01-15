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

            if ($req['id'] > 0) {
                $upd = $this->tasks
                    ->where('task_id', $req['id'])
                    ->set('task_title', $r[0])
                    ->set('task_start', date('Y-m-d H:i:s', strtotime($r[4].':00')))
                    ->set('task_end', date('Y-m-d H:i:s', strtotime($r[5].':00')))
                    ->set('task_is_autosubmit', $r[6])
                    ->set('task_instruction', $r[7])
                    ->set('task_status', $r[12])
                    ->set('task_group', json_encode($group))
                    ->update();

                $res = [
                    'typ' => $req['type'],
                    'sts' => $upd,
                    'msg' => $upd ? 'Tugas berhasil diubah' : 'Tugas gagal diubah',
                    'icn' => $upd ? 'success' : 'error',
                ];
                echo json_encode($res);

            } else {
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
            }

        } else if ($req['type'] == 2) {
            $success = true;
            $i = 0;
            try {
                foreach ($req['id'] as $k => $v) {
                    $this->tasks
                        ->where('task_id', $v)
                        ->set('task_status', $req['param'])
                        ->update();
                    $i++;
                }
                $this->tasks->db->transCommit();
            } catch (\Throwable $th) {
                $success = false;
                $this->tasks->db->transRollback();
            }

            $msg = 'hapus';
            if($req['param'] == 2) {
                $msg = "terbitkan";
            } else if ($req['param'] == 1) {
                $msg = 'batalkan';
            }

            $res = [
                'typ' => $req['type'],
                'sts' => $success,
                'msg' => $success ? $i . ' Tugas berhasil di '.$msg : $i . ' Tugas gagal di '. $msg,
                'icn' => $success ? 'success' : 'error',
            ];
            echo json_encode($res);

        } else if ($req['type'] == 3) {
            $tasks = [];
            $tasks['std'] = $req['param'][0];
            $tasks['me'] = $req['param'][1];
            $tasks['pub'] = $req['param'][2];

            $upd = $this->tasks
                ->set('task_task_ids', json_encode($tasks))
                ->set('task_updated_by', userdata()['user_id'])
                ->where('task_id', $req['id'])
                ->update();

            $res = [
                'typ' => $req['type'],
                'sts' => $upd,
                'msg' => $upd ? 'Penilaian berhasil di sesuaikan' : 'Penilaian gagal di sesuaikan',
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

        if ($req['page-task'] == 1) {
            $get = $this->tasks
                ->where('task_status', 1)
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->orderBy('task_id', 'desc')
                ->findAll();
        } else if ($req['page-task'] == 2) {
            $get = $this->tasks
                ->where('task_status', 2)
                ->where('task_start >=', date('Y-m-d H:i:s'))
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-task'] == 3) {
            $get = $this->tasks
                ->where('task_status', 2)
                ->where('task_start <=', date('Y-m-d H:i:s'))
                ->where('task_end >=', date('Y-m-d H:i:s'))
                ->where('task_school_id', userdata()['school_id'])
                ->where('task_teacher_id', userdata()['id_profile'])
                ->findAll();
        } else if ($req['page-task'] == 4) {
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
                $groups .= '<a href="'. base_url('teacher/groups/view-students/' . $val->id).'" class="badge badge-info mx-1">'.$val->group.'</a>';
            }

            $lesson = '<badge class="badge badge-primary" onclick="lesson_preview('.$v['task_lesson_id'].', '.$v['task_lesson_src'].', '.$v['task_id'].')">'.$v['task_lesson_name'].'</badge>';


            $acts = '';
            if ($req['page-task'] == 1) {
                $acts = '
                    <badge class="badge badge-success" data-bs-placement="top" title="Atur Soal" onclick="view_quest_bank('.$v['task_id'].', '.$v['task_subject_id'].', '.$v['task_grade'].')"><i class="bi bi-gear-fill fs-6 text-white"></i></badge>
                    <badge class="badge badge-dark" data-bs-placement="top" title="Ubah" onclick="edit_task('.$v['task_id'].')"><i class="bi bi-pencil-square fs-6 text-white"></i></badge>
                ';
            }

            $data[] = [
                'act' => $acts,
                'id' => $v['task_id'],
                'title' => $v['task_title'],
                'end_date' => $v['task_end'],
                'lesson' => $lesson,
                'period' => datetime_indo($v['task_start']).' - '.datetime_indo($v['task_end']),
                'group' => $groups,
                'acts' => $acts,
            ];
        }

        echo (json_encode($data));
    }

    public function task_lesson()
    {
        $req = $this->request->getVar();

        if ($req['src'] == 2) {
            $data = $this->lesson_standart
                ->select('
                    lesson_standart_id as lesson_additional_id,
                    lesson_standart_content as lesson_additional_content,
                    lesson_standart_content_path as lesson_additional_content_path,
                    lesson_standart_video_path as lesson_additional_video_path,
                    lesson_standart_attachment_path as lesson_additional_attachment_path,
                    lesson_standart_tasks as lesson_additional_tasks,
                ')
                ->where('lesson_standart_id', $req['id'])
                ->first();
        } else {
            $data = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->first();
        }

        $task = $this->tasks->select('task_task_ids')->where('task_id', $req['task_id'])->first();

        $res = [
            'lesson' => $data,
            'task' => $task
        ];

        echo json_encode($res);
    }

    public function get_edit() 
    {
        $id = $this->request->getVar('id');
        $data = $this->tasks->where('task_id', $id)->first();
        echo json_encode($data);
    }
}  