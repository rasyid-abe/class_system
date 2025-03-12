<?php

namespace App\Controllers\LearningMS\Tasks;

use App\Controllers\BaseController;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Systems\StudentInGroupModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\Tasks\TasksModel;
use App\Models\Tasks\TasksResultModel;
use \Datetime;

class Task extends BaseController
{
    protected $title;
    protected $page;
    protected $teacher_subject;
    protected $teacher;
    protected $subject;
    protected $lesson_standart;
    protected $lesson_additional;
    protected $lesson_public;
    protected $task;
    protected $task_result;
    protected $in_group;
    protected $qc_me;
    protected $qc_std;

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
        $this->task = new TasksModel();
        $this->qc_me = new QuestionBankModel();
        $this->qc_std = new StandartQuestionBankModel();
        $this->task_result = new TasksResultModel();
        $this->in_group = new StudentInGroupModel();
    }

    // BEGIN TEACHER FUNCTION
    public function index()
    {
        $data["title"] = 'Tambah Tugas';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Add_Task';
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
                ->groupBy('lesson_additional_chapter')
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
                    ->where('lesson_standart_grade', $grade)
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
                    ->select('
                        lesson_standart_id as lesson_id,
                        lesson_standart_subject_id as lesson_subject_id,
                        lesson_standart_grade as lesson_grade,
                        lesson_standart_chapter as lesson_chapter,
                        lesson_standart_subchapter as lesson_subchapter,
                        lesson_standart_content as lesson_content,
                        lesson_standart_content_path as lesson_content_path,
                        lesson_standart_video_path as lesson_video_path,
                        lesson_standart_attachment_path as lesson_attachment_path,
                        lesson_standart_tasks as lesson_task,
                    ')
                    ->where('lesson_standart_id', $req['id'])
                    ->where('lesson_standart_status < 9')
                    ->first();
            } else {
                $data = $this->lesson_additional
                    ->select('
                        lesson_additional_id as lesson_id,
                        lesson_additional_subject_id as lesson_subject_id,
                        lesson_additional_grade as lesson_grade,
                        lesson_additional_chapter as lesson_chapter,
                        lesson_additional_subchapter as lesson_subchapter,
                        lesson_additional_content as lesson_content,
                        lesson_additional_content_path as lesson_content_path,
                        lesson_additional_video_path as lesson_video_path,
                        lesson_additional_attachment_path as lesson_attachment_path,
                        lesson_additional_tasks as lesson_task,
                    ')
                    ->where('lesson_additional_id', $req['id'])
                    ->where('lesson_additional_status < 9')
                    ->first();

            }

            $task = json_decode($data['lesson_task']);
            $data['task'] = $task ? (array)$task : [];
            $data['attach_arr'] = $data['lesson_attachment_path'] != '' ? array_values(json_decode($data['lesson_attachment_path'], true)) : [];

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
                    ->select('lesson_standart_tasks as task')
                    ->where('lesson_standart_id', $r[8])
                    ->where('lesson_standart_status < 9')
                    ->first();
            } else {
                $lsrc = $this->lesson_additional
                    ->select('lesson_additional_tasks as task')
                    ->where('lesson_additional_id', $r[8])
                    ->where('lesson_additional_status < 9')
                    ->first();
            }

            if ($req['id'] > 0) {
                $this->task->db->transBegin();

                try {
                    $upd = $this->task
                        ->where('task_id', $req['id'])
                        ->set('task_title', $r[0])
                        ->set('task_start', date('Y-m-d H:i:s', strtotime($r[4].':00')))
                        ->set('task_end', date('Y-m-d H:i:s', strtotime($r[5].':00')))
                        ->set('task_is_autosubmit', $r[6])
                        ->set('task_religion', $r[14])
                        ->set('task_instruction', $r[7])
                        ->set('task_status', $r[12])
                        ->set('task_group', json_encode($group))
                        ->update();

                    foreach ($group as $k => $v) {
                        $students = $this->in_group->list_for_assessment($v['id'], userdata()['school_id'], $r[14]);
                
                        $data_exists = [];
                        $data_exists['task_result_task_id'] = $req['id'];
                        $data_exists['task_result_school_id'] = userdata()['school_id'];

                        $this->task_result->where($data_exists)->delete();

                        foreach ($students as $key => $val) {
                            $data_res = [];
                            $data_res['task_result_id'] = $req['id'] . userdata()['school_id'] . $v['id'] . $val['student_in_group_student_id'];
                            $data_res['task_result_task_id'] = $req['id'];
                            $data_res['task_result_school_id'] = userdata()['school_id'];
                            $data_res['task_result_group_id'] = $v['id'];
                            $data_res['task_result_student_id'] = $val['student_in_group_student_id'];

                            $this->task_result->insert($data_res);
                        }
                    }

                    $this->task->db->transCommit();

                    $res = [
                        'typ' => $req['type'],
                        'sts' => $upd,
                        'msg' => $upd ? 'Tugas berhasil diubah' : 'Tugas gagal diubah',
                        'icn' => $upd ? 'success' : 'error',
                    
                    ];

                } catch (\Throwable $th) {
                    $this->task->db->transRollback();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => 'Tugas gagal ditambahkan',
                        'icn' => 'error',
                    ];
                }
                
                echo json_encode($res);

            } else {

                $this->task->db->transBegin();

                try {
                    $data = [
                        'task_school_id' => userdata()['school_id'],
                        'task_teacher_id' => userdata()['id_profile'],
                        'task_grade' => $r[2],
                        'task_subject_id' => $r[1],
                        'task_group' => json_encode($group),
                        'task_title' => $r[0],
                        'task_lesson_id' => $r[8],
                        'task_lesson_src' => $r[11],
                        'task_task_ids' => $lsrc['task'],
                        'task_start' => date('Y-m-d H:i:s', strtotime($r[4].':00')),
                        'task_end' => date('Y-m-d H:i:s', strtotime($r[5].':00')),
                        'task_is_autosubmit' => $r[6],
                        'task_religion' => $r[14],
                        'task_instruction' => $r[7],
                        'task_status' => $r[12],
                    ];
        
                    $ins = $this->task->insert($data);

                    foreach ($group as $k => $v) {
                        $students = $this->in_group->list_for_assessment($v['id'], userdata()['school_id'], $r[14]);
                
                        foreach ($students as $key => $val) {
                            $data_res = [];
                            $data_res['task_result_id'] = $this->task->getInsertID() . userdata()['school_id'] . $v['id'] . $val['student_in_group_student_id'];
                            $data_res['task_result_task_id'] = $this->task->getInsertID();
                            $data_res['task_result_school_id'] = userdata()['school_id'];
                            $data_res['task_result_group_id'] = $v['id'];
                            $data_res['task_result_student_id'] = $val['student_in_group_student_id'];

                            $inss = $this->task_result->insert($data_res);
                            if ($inss === false) {
                                throw new \Exception('Insert student failed!');
                            }
                        }
                    }

                    $this->task->db->transCommit();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => 'Tugas berhasil ditambahkan',
                        'icn' => 'success'
                    ];
                    echo json_encode($res);

                } catch (\Throwable $th) {
                    $this->task->db->transRollback();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => 'Tugas gagal ditambahkan',
                        'icn' => 'error',
                    ];
                    echo json_encode($res);
                }
            }

        } else if ($req['type'] == 2) {
            $success = true;
            $i = 0;
            try {
                foreach ($req['id'] as $k => $v) {
                    $this->task
                        ->where('task_id', $v)
                        ->set('task_status', $req['param'])
                        ->update();
                    $i++;
                }
                $this->task->db->transCommit();
            } catch (\Throwable $th) {
                $success = false;
                $this->task->db->transRollback();
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
            $task = [];
            $task['std'] = $req['param'][0];
            $task['me'] = $req['param'][1];
            $task['pub'] = $req['param'][2];

            $upd = $this->task
                ->set('task_task_ids', json_encode($task))
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
        $data["sidebar"] = 'Draft_Task';
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
        $data["sidebar"] = 'Scheduled_Task';
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
        $data["sidebar"] = 'Present_Task';
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
        $data["sidebar"] = 'Done_Task';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        return view("learningms/tasks/done", $data);
    }

    public function list_task()
    {
        $req = $this->request->getVar();
        
        $select = '
                task_id, 
                task_group,
                task_grade,
                task_title,
                task_start,
                task_end,
                task_lesson_id,
                task_lesson_src,
                task_task_ids,
                task_subject_id,
                subject_name,
                lesson_additional_chapter,
                lesson_additional_subchapter,
                lesson_standart_chapter,
                lesson_standart_subchapter
            ';

        
        $school_id = userdata()['school_id'];
        $teacher_id = userdata()['id_profile'];
        $date_now = date('Y-m-d H:i:s');
            
        if ($req['page-task'] == 1) {
            $get = $this->task->data_draft($select, $school_id, $teacher_id, $date_now);
        } else if ($req['page-task'] == 2) {
            $get = $this->task->data_scheduled($select, $school_id, $teacher_id, $date_now);
        } else if ($req['page-task'] == 3) {
            $get = $this->task->data_present($select, $school_id, $teacher_id, $date_now);
        } else if ($req['page-task'] == 4) {
            $get = $this->task->data_done($select, $school_id, $teacher_id, $date_now);
        }

        $data = [];
        foreach ($get as $k => $v) {
            $groups = '';
            foreach (json_decode($v['task_group']) as $key => $val) {
                $groups .= '<a href="'. base_url('teacher/groups/view-students/' . $val->id).'" class="badge badge-info">'.$val->group.'</a>&nbsp;';
            }

            $chap_title = '';
            if ($v['task_lesson_src'] == 2) {
                $chap_title = $v['lesson_standart_chapter'] .' - '. $v['lesson_standart_subchapter'];
            } else {
                $chap_title = $v['lesson_additional_chapter'] .' - '. $v['lesson_additional_subchapter'];
            }

            $lesson = '<badge class="badge badge-primary" onclick="lesson_preview('.$v['task_lesson_id'].', '.$v['task_lesson_src'].', '.$v['task_id'].')">'.$chap_title.'</badge>';


            $lists = '';
            if ($req['page-task'] == 1) {
                $acts = '
                    <div class="d-flex flex-column">
                    <badge class="badge badge-success mb-1" data-bs-placement="top" title="Atur Soal" onclick="view_quest_bank('.$v['task_id'].', '.$v['task_subject_id'].', '.$v['task_grade'].')"><i class="bi bi-gear-fill fs-6 text-white"></i></badge>
                    <badge class="badge badge-dark" data-bs-placement="top" title="Ubah" onclick="edit_task('.$v['task_id'].')"><i class="bi bi-pencil-square fs-6 text-white"></i></badge>
                    </div>
                ';

                $lists = '
                <div class="row bigrow-tabulator">
                    <div class="col-lg-4 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-start">
                                '.$acts.'
                                <div class="flex-grow-1 me-2 mx-5 center">
                                    <h6 class="mb-1">'.$v['task_title'].'</h6>
                                    <span class="text-gray-700 d-block">'.$lesson.'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mx-auto">
                        <div class="additional-info">
                            <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                <span class="text-gray-800 fw-semibold">'.$v['subject_name'].'</span>
                                <div class="bdg-group">
                                '.$groups.'
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mx-auto">
                        <div class="additional-info">
                            <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_start']).'</span>
                                <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_end']).'</span>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            } else {
                $lists = '
                <div class="row bigrow-tabulator">
                    <div class="col-lg-4 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1 me-2 center">
                                    <h6 class="mb-1">'.$v['task_title'].'</h6>
                                    <span class="text-gray-700 d-block">'.$lesson.'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mx-auto">
                        <div class="additional-info">
                            <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                <span class="text-gray-800 fw-semibold">'.$v['subject_name'].'</span>
                                <div class="bdg-group">
                                '.$groups.'
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mx-auto">
                        <div class="additional-info">
                            <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_start']).'</span>
                                <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_end']).'</span>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }

            $data[] = [
                'id' => $v['task_id'],
                'title' => $v['task_title'],
                'end_date' => $v['task_end'],
                'lesson' => $lesson,
                'period' => datetime_indo($v['task_start']).' - '.datetime_indo($v['task_end']),
                'group' => $groups,
                'lists' => $lists
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

        $task = $this->task->select('task_task_ids')->where('task_id', $req['task_id'])->first();

        $res = [
            'lesson' => $data,
            'task' => $task
        ];

        echo json_encode($res);
    }

    public function get_edit() 
    {
        $id = $this->request->getVar('id');
        
        $select = '
            task_id, 
            task_group,
            task_grade,
            task_title,
            task_start,
            task_end,
            task_lesson_id,
            task_lesson_src,
            task_task_ids,
            task_subject_id,
            task_religion,
            subject_name,
            lesson_additional_chapter,
            lesson_additional_subchapter,
            lesson_standart_chapter,
            lesson_standart_subchapter
        ';

        $data = $this->task
            ->select($select)
            ->join('master_subject', 'subject_id=task_subject_id', 'left')
            ->join('lms_lesson_additional', 'task_lesson_id=lesson_additional_id', 'left')
            ->join('lms_lesson_standart', 'task_lesson_id=lesson_standart_id', 'left')
            ->where('task_id', $id)->first();

        echo json_encode($data);
    }

    // BEGIN STUDENT FUNCTION
    public function s_index_present()
    {
        $data["title"] = 'Aktif';
        $data["page"] = 'Student Task';
        $data["sidebar"] = 'Present_Task';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Aktif',
        ];

        return view("learningms/tasks/present_s", $data);
    }

    public function s_index_done()
    {
        $data["title"] = 'Selesai';
        $data["page"] = 'Student Task';
        $data["sidebar"] = 'Done_Task';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        return view("learningms/tasks/done_s", $data);
    }

    public function s_index_missed()
    {
        $data["title"] = 'Terlewat';
        $data["page"] = 'Student Task';
        $data["sidebar"] = 'Missed_Task';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Terlewat',
        ];

        return view("learningms/tasks/missed", $data);
    }

    public function s_list_task()
    {
        $req = $this->request->getVar();
        $list = $this->task->get_list_student_task($req['page-task']);

        $my_task = $this->task_result
            ->select('task_result_task_id task_id')
            ->where('task_result_student_id', userdata()['id_profile'])
            ->findAll();

        $my_assign = array_column($my_task, 'task_id');
        $my_list = array_column($list, 'task_id');

        $merge_idx = array_merge($my_assign, $my_list);
        $list_idx = array_unique(array_diff_assoc($merge_idx, array_unique($merge_idx)));

        // $list = $this->task->get_list_task($req['page-task']);

        $data = [];
        foreach ($list as $k => $v) {
            if ($req['page-task'] == 1 || $req['page-task'] == 2) {
                
                if (in_array($v['task_id'], $list_idx)) {
                    $deg = $v['teacher_degree'] != '' ? ', '.$v['teacher_degree'] : '';
                    $name = $v['teacher_first_name'].' '.$v['teacher_last_name'] . $deg;
                    
                    $button = '';
                    if ($req['page-task'] == 1) {
                        $button = '<a href="#" class="btn btn-primary pl-10" onclick="begin_task(' . $v['task_id'] . ')">Kerjakan</a>';
                    }

                    $lists = '
                    <div class="row bigrow-tabulator">
                        <div class="col-lg-4 mx-auto">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    ' . $button . '
                                    <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                        <h5 class="">' . $v['task_title'] . '</h5>
                                        <badge class="badge badge-info">'.$v['subject_name'].'</badge>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-800 fw-semibold">'.$name.'</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_start']).'</span>
                                    <span class="text-gray-700 fw-semibold">'.datetime_indo($v['task_end']).'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
        
                    $data[] = [
                        'id' => $v['task_id'],
                        'lists' => $lists
                    ];
                }
            }



        }

        echo (json_encode($data));
   
    }

    public function s_act_get_task() {
        $id = $this->request->getVar('id');
        $row = $this->task
            ->join('master_subject', 'subject_id=task_subject_id', 'left')
            ->join('profile_teacher', 'teacher_id=task_teacher_id', 'left')
            ->where('task_id', $id)
            ->first();

        if ($row['task_lesson_src'] == 2) {
            $less = $this->lesson_standart
            ->select('
                lesson_standart_chapter as chapter,
                lesson_standart_subchapter as subchapter,
                lesson_standart_content as content,
                lesson_standart_content_path as file_content,
                lesson_standart_video_path as video,
                lesson_standart_attachment_path as attach,
            ')
            ->where('lesson_standart_id', $row['task_lesson_id'])->first();
        } else {
            $less = $this->lesson_additional
            ->select('
                lesson_additional_chapter as chapter,
                lesson_additional_subchapter as subchapter,
                lesson_additional_content as content,
                lesson_additional_content_path as file_content,
                lesson_additional_video_path as video,
                lesson_additional_attachment_path as attach,
            ')
            ->where('lesson_additional_id', $row['task_lesson_id'])->first();
        }

        $deg = $row['teacher_degree'] != '' ? ', ' . $row['teacher_degree'] : '';

        $data = [];
        $data['title'] = $row['task_title'];
        $data['teacher'] = $row['teacher_first_name'] . ' ' . $row['teacher_last_name'] . $deg;
        $data['teacher_id'] = $row['task_title'];
        $data['subject'] = $row['subject_name'];
        $data['start'] = $row['task_start'];
        $data['end'] = $row['task_end'];
        $data['auto_submit'] = $row['task_is_autosubmit'];
        $data['instruction'] = $row['task_instruction'];
        $data['chapter'] = $less['chapter'];
        $data['subchapter'] = $less['subchapter'];
        $data['content'] = $less['content'];
        $data['file_content'] = $less['file_content'];
        $data['video'] = $less['video'];
        $data['attach'] = $less['attach'];

        $all_task = [];
        foreach (json_decode($row['task_task_ids']) as $k => $v) {
            if ($v != 'empty') {
                foreach ($v as $val) {
                    if ($k == 'std') {
                        $all_task[$k][] = $this->qc_std
                            ->select('
                                question_bank_standart_id as question_bank_id,
                                question_bank_standart_question as question_bank_question,
                                question_bank_standart_option as question_bank_option,
                                question_bank_standart_hint as question_bank_hint,
                                question_bank_standart_type as question_bank_type,                               
                            ')
                            ->where('question_bank_standart_id', $val)
                            ->first();
                    } else {
                        $all_task[$k][] = $this->qc_me
                            ->select('
                                question_bank_id,
                                question_bank_question,
                                question_bank_option,
                                question_bank_hint,
                                question_bank_type,
                            ')
                            ->where('question_bank_id', $val)
                            ->first();
                    }
                }
            }
        }

        $quest = [];
        foreach ($all_task as $k=> $v) {
            foreach ($v as $val) {
                $opt = json_decode($val['question_bank_option']);
                $opts = [];
                foreach ($opt as $key => $value) {
                    $opts['opt_' . $key + 1] = $value;
                }

                $quest[$k . '_' . $val['question_bank_id']]['id'] = $val['question_bank_id'];
                $quest[$k . '_' . $val['question_bank_id']]['question'] = $val['question_bank_question'];
                $quest[$k . '_' . $val['question_bank_id']]['option'] = $opts;
                $quest[$k . '_' . $val['question_bank_id']]['type'] = $val['question_bank_type'];
                $quest[$k . '_' . $val['question_bank_id']]['hint'] = $val['question_bank_hint'];
                $quest[$k . '_' . $val['question_bank_id']]['student_answer'] = [];
                
            }
        }

        $data['tasks'] = $quest;

        $storage = [
            'key' => 'bluecode_' . userdata()['id_profile'],
            'value' => $data
        ];
        
        echo json_encode($storage);

    }
}  