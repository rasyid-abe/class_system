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
use App\Models\Tasks\TasksTempModel;
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
    protected $task_temp;
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
        $this->task_temp = new TasksTempModel();
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
                        ->set('task_is_ignored_time_submit', $r[6])
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
                        'task_is_ignored_time_submit' => $r[6],
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
                    if ($req['param'] == 9) {
                        $data_exists = [];
                        $data_exists['task_result_task_id'] = $req['id'];
                        $data_exists['task_result_school_id'] = userdata()['school_id'];

                        $this->task_result->where($data_exists)->delete();
                    }

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
                if ($req['page-task'] > 2) {
                    $groups .= '<a href="" data-group_id="'.$val->id.'" data-task_id="'. $v['task_id'] .'" class="badge badge-info view_student_task">'.$val->group.'</a>&nbsp;';
                } else {
                    $groups .= '<a href="'. base_url('teacher/groups/view-students/' . $val->id).'" class="badge badge-info">'.$val->group.'</a>&nbsp;';
                }
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
                'task_ids' => $v['task_task_ids'],
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
            task_is_ignored_time_submit,
            task_instruction,
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

    public function get_student_task()
    {
        $req = $this->request->getVar();

        $rows = $this->task_result
            ->select('
                task_result_id as result_id,
                task_result_task_id as task_id,
                task_result_group_id as group_id,
                task_result_student_id as student_id,
                task_result_begin_task_datetime as begin_task_datetime,
                task_result_submit_datetime as submit_datetime,
                task_result_value as value,
                task_result_submit_message as submit_message,
                student_nisn,
                student_first_name,
                student_last_name
            ')
            ->join('profile_student', 'student_id=task_result_student_id', 'left')
            ->where('task_result_task_id', $req['tid'])
            ->where('task_result_school_id', userdata()['school_id'])
            ->where('task_result_group_id', $req['gid'])
            ->findAll();

        $data = [];
        foreach ($rows as $v) {
            $begin = $v['begin_task_datetime'] != null ? '<span class="text-gray-700 fw-bold" style="width: 65px">Mulai </span><badge class="badge badge-success" onclick="lesson_preview(18, 2, 15)"><b>' . datetime_indo($v['begin_task_datetime']) . '</b></badge>' : '';
            $submit = $v['submit_datetime'] != null ? '<span class="text-gray-700 fw-bold" style="width: 65px">Selesai </span><badge class="badge badge-success" onclick="lesson_preview(18, 2, 15)"><b>' . datetime_indo($v['submit_datetime']) . '</b></badge>' : '';

            // $value = $v['value'] != null ? '<badge class="badge badge-info my-1">Nilai : <b>' . $v['value'] . ' Poin</b></badge> &nbsp;' : '';
            $value = $v['value'] != null ? '<a href="#" onclick="data_result_student_tsk('.$v['result_id'].')" class="badge badge-info my-1">Periksa</b></a> &nbsp;' : '';
            $desc = $v['submit_message'] != null ? 'Ket : ' . $v['submit_message'] : '';

            if ($v['value'] != null) {
                $start = new DateTime($v['begin_task_datetime']);
                $end = new DateTime($v['submit_datetime']);
                $interval = $start->diff($end);
            }

            $duration = $v['value'] != null ? '<badge class="badge badge-danger my-1"><b>Dikerjakan selama ' . $interval->format('%d Hari %h Jam %i Menit') . '</b></badge>' : '';

            $lists = '
                <div class="row bigrow-tabulator">
                    <div class="col-lg-4 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-start">
                        
                                <div class="d-flex flex-column">
                                    <div class="cursor-pointer symbol symbol-50px" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="User profile">
                                        <img src="http://localhost:8080/assets/media/avatars/150-26.jpg" alt="image">
                                    </div>
                                </div>
                        
                                <div class="flex-grow-1 me-2 mx-5 center">
                                <h6>' . $v['student_first_name'] . ' ' . $v['student_last_name'] . '</h6>
                                <span class="text-gray-700 d-block">
                                    <badge class="badge badge-primary" onclick="lesson_preview(18, 2, 15)">NISN: ' . $v['student_nisn'] . '</badge>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mx-auto">
                        <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                            <div class="d-flex justify-content-between mb-1">' . $begin . '</div>
                            <div class="d-flex justify-content-between">' . $submit . '</div>
                        </div>
                    </div>
                    <div class="col-lg-5 mx-auto">
                        <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                            <div class="d-flex justify-content-between">' . $value . $duration . '</div>
                            ' . $desc . '
                        </div>
                    </div>
                </div>
            ';

            $data[] = [
                'student_id' => $v['student_id'],
                'lists' => $lists,
            ];
        }

        echo (json_encode($data));
    }

    public function check_result_task()
    {
        $result_id = $this->request->getVar('result_id');
        $result = $this->task_result
            ->join('lms_task', 'task_id=task_result_task_id', 'left')
            ->join('master_subject', 'subject_id=task_subject_id', 'left')
            ->where('task_result_id', $result_id)->first();

        $all_task = [];
        foreach (json_decode($result['task_result_answer']) as $k => $v) {
            foreach ($v as $val) {
                if ($k == 'std') {
                    $all_task[$k][] = $this->qc_std
                        ->select('
                            question_bank_standart_id as id,
                            question_bank_standart_question as question,
                            question_bank_standart_option as option,
                            question_bank_standart_answer as answer,
                            question_bank_standart_hint as hint,
                            question_bank_standart_type as type,                               
                            question_bank_standart_poin as poin                               
                        ')
                        ->where('question_bank_standart_id', $val->id)
                        ->first();
                } else {
                    $all_task[$k][] = $this->qc_me
                        ->select('
                            question_bank_id as id,
                            question_bank_question as question,
                            question_bank_option as option,
                            question_bank_answer as answer,
                            question_bank_hint as hint,
                            question_bank_type as type,
                            question_bank_poin as poin
                        ')
                        ->where('question_bank_id', $val->id)
                        ->first();
                }
            }
        }

        $storage = [];
        $storage['task_id'] = $result['task_id'];
        $storage['task_title'] = $result['task_title'];
        $storage['subject'] = $result['subject_name'];

        $quests = [];
        $arr_src = ['me' => 1, 'pub' => 2, 'std' => 3];
        foreach ($all_task as $k => $v) {
            foreach ($v as  $val) {
                $quests[$k.'_'.$val['id']]['question_id'] = $k.'_'.$val['id'];
                $quests[$k.'_'.$val['id']]['question'] = $val['question'];

                $answ = [];
                foreach (json_decode($result['task_result_answer']) as $idx => $value) {
                    foreach ($value as $kk => $vv) {
                        if ($vv->id == $val['id']) {
                            $answ[] = $vv->student_answer;
                            if (isset($vv->poin)) {
                                $quests[$k.'_'.$val['id']]['note_check'] = $vv->note_check;
                                $quests[$k.'_'.$val['id']]['res_poin'] = (float)$vv->poin;
                            } else {
                                $quests[$k.'_'.$val['id']]['note_check'] = '';
                                $quests[$k.'_'.$val['id']]['res_poin'] = 0;
                            }
                            $quests[$k.'_'.$val['id']]['checked'] = $vv->checked;
                        }
                    }
                }

                if ($val['type'] < 4) {
                    $opts = [];
                    foreach (json_decode($val['option']) as $key => $value) {
                        $opts['opt_' . $key + 1] = $value;
                    }

                    $quests[$k.'_'.$val['id']]['option'] = $opts;
                } else {
                    $quests[$k.'_'.$val['id']]['option'] = [];
                }

                $quests[$k.'_'.$val['id']]['student_answer'] = $answ;
                $quests[$k.'_'.$val['id']]['right_answer'] = $val['answer'];
                $quests[$k.'_'.$val['id']]['type'] = $val['type'];
                $quests[$k.'_'.$val['id']]['poin'] = $val['poin'];
                $quests[$k.'_'.$val['id']]['hint'] = $val['hint'];
            }
        }

        $storage['tasks'] = $quests;
        
        $data = [
            'key' => 'aquacode_' . userdata()['id_profile'] .'_'. $result['task_result_student_id'],
            'value' => $storage,
            'student_id' => $result['task_result_student_id'],
            'result_id' => $result_id
        ];

        echo json_encode($data);
    }

    public function submit_check_task()
    {
        $req = $this->request->getVar();

        $result = $this->task_result
            ->where('task_result_id', $req['res'])->first();

        $arch_ans = [];
        $total_poin = 0;
        foreach (json_decode($result['task_result_answer']) as $k => $v) {
            foreach ($v as $key => $val) {
                $arch_ans[$k][$key]['id'] = $key;
                $arch_ans[$k][$key]['student_answer'] = $val->student_answer;
                $arch_ans[$k][$key]['checked'] = 1;
                $arch_ans[$k][$key]['poin'] = $req['result'][$k.'_'.$key]['res_poin'];
                $arch_ans[$k][$key]['note_check'] = $req['result'][$k.'_'.$key]['note_check'];
                $total_poin += $req['result'][$k.'_'.$key]['res_poin'];
            }
        }

        $upd = $this->task_result
            ->set('task_result_answer', json_encode($arch_ans))
            ->set('task_result_value', $total_poin)
            ->where('task_result_id', $req['res'])
            ->update();

        if ($upd) {
            $return = [
                'sts' => true,
                'msg' => 'Pemeriksaan berhasil disimpan!',
                'icn' => 'success'
            ];
        } else {
            $return = [
                'sts' => false,
                'msg' => 'Pemeriksaan gagal disimpan!',
                'icn' => 'error'
            ];
        }

        echo json_encode($return);
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

        $my_temp = $this->task_temp
            ->select('task_temp_task_id')
            ->where([
                'task_temp_school_id' => userdata()['school_id'],
                'task_temp_student_id' => userdata()['id_profile'],
            ])->findAll();

        $arr_temp_task = array_column($my_temp, 'task_temp_task_id');

        $data = [];
        foreach ($list as $k => $v) {
            $deg = $v['teacher_degree'] != '' ? ', '.$v['teacher_degree'] : '';
            $name = $v['teacher_first_name'].' '.$v['teacher_last_name'] . $deg;

            if ($req['page-task'] == 1 || $req['page-task'] == 2) {
                $tmp_exists = in_array($v['task_id'], $arr_temp_task) ? 1 : 0;
                $bdg_exsists = '';
                if (in_array($v['task_id'], $arr_temp_task)) {
                    $bdg_exsists = '<badge class="badge badge-danger">Belum dikirim</badge>';
                } else {
                    $bdg_exsists = '<badge class="badge badge-info">Belum dikerjakan</badge>';
                }

                if (in_array($v['task_id'], $list_idx)) {
                    
                    
                    $button = '';
                    if ($req['page-task'] == 1) {
                        if ($v['task_end'] > date('Y-m-d H:i:s') || ($v['task_end'] < date('Y-m-d H:i:s') && $v['task_is_ignored_time_submit'] == 1)) {
                            $button = '<a href="#" class="btn btn-primary pl-10" onclick="begin_task(' . $v['task_id'] . ', '.$tmp_exists.')">Kerjakan</a>';
                            $lists = '
                            <div class="row bigrow-tabulator">
                                <div class="col-lg-4 mx-auto">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            ' . $button . '
                                            <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                                <h5 class="">' . $v['task_title'] . '</h5>
                                                '.$bdg_exsists.'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mx-auto">
                                    <div class="additional-info">
                                        <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                            <span class="text-gray-800 fw-bold d-block">' . $v['subject_name'] . '</span>
                                            <span class="text-gray-700 fw-semibold">' . $name . '</span>
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
                    } else {
                        $lists = '
                        <div class="row bigrow-tabulator">
                            <div class="col-lg-4 mx-auto">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                            <h5 class="">' . $v['task_title'] . '</h5>
                                            '.$bdg_exsists.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mx-auto">
                                <div class="additional-info">
                                    <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                        <span class="text-gray-800 fw-bold d-block">' . $v['subject_name'] . '</span>
                                        <span class="text-gray-700 fw-semibold">' . $name . '</span>
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
            } else {
                if ($v['task_result_submit_datetime'] < $v['task_result_end_datetime']) {
                    $bdg_exsists = '<badge class="badge badge-success">Waktu Submit : '.datetime_indo($v['task_result_submit_datetime']).'</badge>';
                } else {
                    $bdg_exsists = '<badge class="badge badge-danger">Waktu Submit : '.datetime_indo($v['task_result_submit_datetime']).'</badge>';
                }

                $lists = '
                    <div class="row bigrow-tabulator">
                        <div class="col-lg-4 mx-auto">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                        <h5 class="">' . $v['task_title'] . '</h5>
                                        '.$bdg_exsists.'
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-800 fw-bold d-block">' . $v['subject_name'] . '</span>
                                    <span class="text-gray-700 fw-semibold">' . $name . '</span>
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

        echo (json_encode($data));
   
    }

    public function s_act_get_task() 
    {
        $id = $this->request->getVar('id');
        $temp = $this->request->getVar('temp');
        
        if ($temp < 1) {
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
            $data['task_id'] = $row['task_id'];
            $data['title'] = $row['task_title'];
            $data['teacher'] = $row['teacher_first_name'] . ' ' . $row['teacher_last_name'] . $deg;
            $data['teacher_id'] = $row['task_title'];
            $data['subject'] = $row['subject_name'];
            $data['subject_id'] = $row['subject_id'];
            $data['begin_task'] = date('Y-m-d H:i:s');
            $data['start'] = $row['task_start'];
            $data['end'] = $row['task_end'];
            $data['ignore_time'] = $row['task_is_ignored_time_submit'];
            $data['instruction'] = $row['task_instruction'];
    
            $lesson = [];
            $lesson['lesson_additional_chapter'] = $less['chapter'];
            $lesson['lesson_additional_subchapter'] = $less['subchapter'];
            $lesson['lesson_additional_content'] = $less['content'];
            $lesson['lesson_additional_content_path'] = $less['file_content'];
            $lesson['lesson_additional_video_path'] = $less['video'];
            $lesson['lesson_additional_attachment_path'] = $less['attach'];
            $lesson['attach_arr'] = $less['attach'] != '' ? array_values(json_decode($less['attach'], true)) : [];
    
            $data['lesson'] = $lesson;

            $data['tasks'] = [];
            if ($row['task_task_ids'] != null) {
                $all_task = [];
                foreach (json_decode($row['task_task_ids']) as $k => $v) {
                    if ($v != 'empty') {
                        foreach ($v as $val) {
                            if ($k == 'std') {
                                $all_task[$k][] = $this->qc_std
                                    ->select('
                                        question_bank_standart_id as id,
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
                                        question_bank_id as id,
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
        
                        $quest[$val['id']]['source'] = $k;
                        $quest[$val['id']]['question_id'] = $val['id'];
                        $quest[$val['id']]['question'] = $val['question_bank_question'];
                        $quest[$val['id']]['option'] = $opts;
                        $quest[$val['id']]['type'] = $val['question_bank_type'];
                        $quest[$val['id']]['hint'] = $val['question_bank_hint'];
                        $quest[$val['id']]['student_answer'] = '[]';
                        
                    }
                }
        
                $data['tasks'] = $quest;
            }

            try {
                $this->task_result
                    ->where('task_result_student_id', userdata()['id_profile'])
                    ->where('task_result_task_id', $row['task_id'])
                    ->where('task_result_school_id', userdata()['school_id'])
                    ->set('task_result_begin_task_datetime', date('Y-m-d H:i:s'))
                    ->update();
            } catch (\Throwable $th) {
                echo '<pre>';
                print_r('Terjadi kesalahan');
                echo '</pre>';
                die;
            }

            $storage = [
                'task_id' => $id,
                'key' => 'bluecode_' . userdata()['id_profile'] . '_' . $id,
                'value' => $data,
                'tasks' => $data['tasks']
            ];
        } else {
            $my_temp = $this->task_temp
            ->where([
                'task_temp_school_id' => userdata()['school_id'],
                'task_temp_student_id' => userdata()['id_profile'],
                'task_temp_task_id' => $id
            ])->first();

            $data = json_decode($my_temp['task_temp_data']);

            $storage = [
                'task_id' => $id,
                'key' => 'bluecode_' . userdata()['id_profile'] . '_' . $id,
                'value' => $data,
                'tasks' => count((array)$data->tasks) > 0 ? [1] : []
            ];
        }
        
        echo json_encode($storage);

    }

    public function s_save_action_task()
    {
        $req = $this->request->getVar('send');

        if ($req['type'] == 1) {

            $data_exists = [];
            $data_exists['task_temp_school_id'] = userdata()['school_id'];
            $data_exists['task_temp_student_id'] = userdata()['id_profile'];
            $data_exists['task_temp_task_id'] = $req['task_id'];

            $this->task_temp->where($data_exists)->delete();

            $data = [
                'task_temp_id' => userdata()['school_id'] . userdata()['id_profile'] . $req['subject_id'] . $req['task_id'],
                'task_temp_school_id' => userdata()['school_id'],
                'task_temp_student_id' => userdata()['id_profile'],
                'task_temp_subject_id' => $req['subject_id'],
                'task_temp_task_id' => $req['task_id'],
                'task_temp_data' => $req['data']
            ];
  
            try {
                $this->task_temp->insert($data);
                $res = [
                    'sts' => true,
                    'msg' => 'Berhasil disimpan.',
                    'icn' => 'success',
                ];
            } catch (\Throwable $th) {
                $res = [
                    'sts' => false,
                    'msg' => '<h2>Oops..</h2><br><p>Tugas <b>' . $req['title'] . '</b> mata pelajaran <b>' . $req['subject'] . '</b> gagal dikirimkan</p>',
                    'icn' => 'error',
                ];
            }
  
            echo json_encode($res);
        } else {
            $total_poin = 0;
            $arch_answer = [];
            foreach ($req['answer'] as $k => $v) {
                if ($v['question_type'] < 4) {
                    $real_ans = [];
                    if ($v['source'] == 'std') {
                        $real_ans = $this->qc_std
                            ->select('
                                question_bank_standart_id as id,
                                question_bank_standart_answer as answer,
                                question_bank_standart_poin as poin                               
                            ')
                            ->where('question_bank_standart_id', $v['question_id'])
                            ->first();
                    } else {
                        $real_ans = $this->qc_me
                            ->select('
                                question_bank_id as id,
                                question_bank_answer as answer,
                                question_bank_poin as poin,                           
                            ')
                            ->where('question_bank_id', $v['question_id'])
                            ->first();
                    }
    
                    $arch_answer[$v['source']][$v['question_id']]['id'] = $v['question_id'];
                    $arch_answer[$v['source']][$v['question_id']]['student_answer'] = $v['answer'];
                    
                    $rans = json_decode($real_ans['answer']);

                    if (count($rans) < 2 ) {
                        if ($v['answer'] == $rans) {
                            $total_poin += $real_ans['poin'];
                            $arch_answer[$v['source']][$v['question_id']]['poin'] = $real_ans['poin'];
                        } else {
                            $arch_answer[$v['source']][$v['question_id']]['poin'] = 0;
                        }
                    } else {
                        if (count($rans) == count($v['answer'])) {
                            $mcx = [];
                            for ($i=0; $i < count($rans); $i++) { 
                                if (in_array($rans[$i], $v['answer'])) {
                                    $mcx[] = true;
                                } else {
                                    $mcx[] = false;
                                }
                            }
                            
                            if (in_array(false, $mcx)) {
                                $total_poin += $real_ans['poin'];
                                $arch_answer[$v['source']][$v['question_id']]['poin'] = $real_ans['poin'];
                            } else {
                                $arch_answer[$v['source']][$v['question_id']]['poin'] = 0;
                            }
                        } else {
                            $arch_answer[$v['source']][$v['question_id']]['poin'] = 0;
                        }
                    }
                    $arch_answer[$v['source']][$v['question_id']]['checked'] = 1;
                } else {
                    $arch_answer[$v['source']][$v['question_id']]['id'] = $v['question_id'];
                    $arch_answer[$v['source']][$v['question_id']]['checked'] = 0;
                    // $arch_answer[$v['source']][$v['question_id']]['poin'] = 0;
                }
                $arch_answer[$v['source']][$v['question_id']]['student_answer'] = $v['answer'];
                $arch_answer[$v['source']][$v['question_id']]['note_check'] = '';
                $arch_answer[$v['source']][$v['question_id']]['question_id'] = $v['question_id'];
            }

            $upd_result = $this->task_result
                ->where('task_result_student_id', userdata()['id_profile'])
                ->where('task_result_task_id', $req['task_id'])
                ->where('task_result_school_id', userdata()['school_id'])
                ->set('task_result_begin_task_datetime', $req['task_begin'])
                ->set('task_result_submit_datetime', date('Y-m-d H:i:s'))
                ->set('task_result_end_datetime', $req['task_end'])
                ->set('task_result_answer', json_encode(($arch_answer)))
                ->set('task_result_value', $total_poin)
                ->set('task_result_submit_type', $req['submit_type'])
                ->set('task_result_submit_message', $req['submit_msg'])
                ->update();

            $msgsmbt = '';
            if ($req['autosubmit'] == 1 ) {
                $msgsmbt = '<h2>Tugas Terkirim Otomatis</h2><br><p>Penilaian <b>' . $req['task_title'] . '</b> mata pelajaran <b>' . $req['subject'] . '</b> terkirim otomatis karena <b>' . $req['submit_msg'] . '</b></p>';
            } else {
                $msgsmbt = '<h2>Sukses</h2><br><p>Penilaian <b>' . $req['task_title'] . '</b> mata pelajaran <b>' . $req['subject'] . '</b> berhasil dikirimkan</p>';    
            }
    
            if ($upd_result) {
                $temp_whr = [
                    'task_temp_school_id' => userdata()['school_id'],
                    'task_temp_student_id' => userdata()['id_profile'],
                    'task_temp_task_id' => $req['task_id']
                ];
                $this->task_temp->where($temp_whr)->delete();
                $res = [
                    'sts' => true,
                    'msg' => $msgsmbt,
                    'icn' => 'success',
                ];
            } else {
                $res = [
                    'sts' => false,
                    'msg' => '<h2>Oops..</h2><br><p>Penilaian <b>' . $req['task_title'] . '</b> mata pelajaran <b>' . $req['subject'] . '</b> gagal dikirimkan</p>',
                    'icn' => 'error',
                ];
            }
            echo json_encode($res);
        }
    }
} 