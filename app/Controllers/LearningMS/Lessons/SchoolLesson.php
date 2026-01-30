<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\SchoolLessonModel;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Lessons\PublicLessonModel;
use App\Models\Management\TeachingSubjectsModel;
use App\Models\Masters\SubjectModel;
use PhpParser\Node\Expr\FuncCall;
use App\Models\Activities\ActivityModel;

class SchoolLesson extends BaseController
{

    protected $title;
    protected $page;
    protected $sidebar;
    protected $lesson_school;
    protected $lesson_standart;
    protected $lesson_additional;
    protected $lesson_public;
    protected $teacher_subject;
    protected $subject;
    protected $activity;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->sidebar = "School";
        $this->page = "Lesson";
        $this->lesson_school = new SchoolLessonModel();
        $this->lesson_standart = new StandartLessonModel();
        $this->lesson_additional = new AdditionalLessonModel();
        $this->lesson_public = new PublicLessonModel();
        $this->teacher_subject = new TeachingSubjectsModel();
        $this->subject = new SubjectModel();
        $this->activity = new ActivityModel();
    }

    // BEGIN TEACHER FUNCTION
    public function index()
    {
        $data["title"] = 'Materi Sekolah';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Sekolah',
        ];


        $subs = [];
        if (isset(school_year()['id'])) {
            $mysubs = $this->teacher_subject
                ->select('student_group_id, student_group_name, student_group_grade, subject_id, subject_name')
                ->join('manage_timetable', 'timetable_teaching_subjects_id = teaching_subjects_id', 'left')
                ->join('master_student_group', 'student_group_id = timetable_group_id', 'left')
                ->join('master_subject', 'subject_id = teaching_subjects_subject_id', 'left')
                ->where('teaching_subjects_school_id', userdata()['school_id'])
                ->where('teaching_subjects_teacher_id', userdata()['id_profile'])
                ->where('teaching_subjects_status < 9')
                ->orderBy('student_group_id')
                ->findAll();
       
            foreach ($mysubs as $k => $v) {
                $subs[$v['subject_id']]['subj_id'] = $v['subject_id'];
                $subs[$v['subject_id']]['subj_name'] = $v['subject_name'];
                $subs[$v['subject_id']]['grade'][$v['student_group_grade']] = $v['student_group_grade'];
            }
        }

        $data['mysubs'] = $subs;
        return view("learningms/lesson_school/index", $data);
    }

    public function first_page()
    {
        $req = $this->request->getVar();

        $sch = userdata()['school_id'];
        $teach = userdata()['id_profile'];
        
        if (isset(school_year()['id'])) {
            $s_year = school_year()['id'];
            $total_chapter = $this->lesson_school->total_chapter($sch, $s_year, $teach);
            $total_subchapter = $this->lesson_school->total_subchapter($sch, $s_year, $teach);
  
            $res = [
                't_chap' => $total_chapter['total'] != '' ? $total_chapter['total'] : 0 ,
                't_subchap' => $total_subchapter['total'] != '' ? $total_subchapter['total'] : 0,
            ];

        } else {
            $res = [
                't_chap' => 0,
                't_subchap' => 0,
            ];
        }


        echo json_encode($res);
    }

    public function view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'] . ' - Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/school' => 'Materi Sekolah',
            '##' => $subs['subject_name'] . ' Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $chapter = $this->lesson_school
            ->select('
                lesson_school_id,
                lesson_school_chapter chapter, 
                lesson_school_lesson_additional_id add, 
                lesson_school_lesson_standart_id std,
                lesson_school_lesson_shared_id shr,
                lesson_school_parent_id,
                lesson_school_order_child,
                lesson_school_order_parent
            ')
            ->where('lesson_school_teacher_id', userdata()['id_profile'])
            ->where('lesson_school_status < 9')
            ->where('lesson_school_subject_id', $subject)
            ->where('lesson_school_grade', $grade)
            ->orderBy('lesson_school_order_parent', 'desc')
            ->findAll();
        
        $result = array();
        foreach ($chapter as $val) {
            
            $rr = [];
            if ($val['add'] > 0 || $val['std'] > 0 || $val['shr'] > 0) {
                if ($val['add'] > 0) {
                    $rr = $this->get_add_lesson($val['add']);
                } elseif ($val['std'] > 0) {
                    $rr = $this->get_std_lesson($val['std']);
                } else {
                    $rr = $this->get_shr_lesson($val['shr']);
                }
            }

            if(count($rr) > 0){
                $rr['order'] = $val['lesson_school_order_child'];
                $rr['parent_id'] = $val['lesson_school_parent_id'];
                $rr['lesson_id'] = $val['lesson_school_id'];
                $result[$val['chapter']]['sub_chapter'][$val['lesson_school_order_child']] = $rr;
            }
            $result[$val['chapter']]['lesson_school_chapter'] = $val['chapter'];
            $result[$val['chapter']]['lesson_school_id'] = $val['lesson_school_id'];
            $result[$val['chapter']]['lesson_school_parent_id'] = $val['lesson_school_parent_id'];
            $result[$val['chapter']]['lesson_school_order_parent'] = $val['lesson_school_order_parent'];
        }
        
        $chp = [];
        foreach ($result as $k => $v) {
            if (isset($v['sub_chapter'])) {
                $sc = $v['sub_chapter'];
                ksort($sc);

                $ii = 0;
                foreach ($v['sub_chapter'] as $key => $val) {
                    if ($ii < 1) {
                        $pid = $val['parent_id'];
                        $odr = $this->lesson_school
                            ->where('lesson_school_id', $pid)
                            ->first();
                    }
                    $ii++;
                }
                $v['sub_chapter'] = $sc;
                $chp[$odr['lesson_school_order_parent']] = $v;
            } else {
                $chp[$v['lesson_school_order_parent']] = $v;
            }
        }

        ksort($chp);
        $data['chapters'] = $chp;

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
                    lesson_additional_id as lesson_id,
                    lesson_additional_content as lesson_content,
                    lesson_additional_subject_id as lesson_subject_id,
                    lesson_additional_grade as lesson_grade,
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
                    lesson_standart_id as lesson_id,
                    lesson_standart_content as lesson_content,
                    lesson_standart_subject_id as lesson_subject_id,
                    lesson_standart_grade as lesson_grade,
                    lesson_standart_content_path as lesson_content_path,
                    lesson_standart_video_path as lesson_video_path,
                    lesson_standart_attachment_path as lesson_attachment_path,
                    lesson_standart_tasks as lesson_task
                ')
                ->where('lesson_standart_id', $id)
                ->where('lesson_standart_status < 9')
                ->first();
        }

        $task = json_decode($data['lesson_task']);

        $data['task'] = $task ? (array)$task : [];
        $data['attach_arr'] = $data['lesson_attachment_path'] != '' ? array_values(json_decode($data['lesson_attachment_path'], true)) : [];
            
        echo json_encode($data);
    }

    public function update_content()
    {
        $req = $this->request->getVar();
        // echo '<pre>';
        // print_r($req);
        // echo '</pre>';
        // die;
        $sts = '';
        if ($req['type'] == 1) {
            $ex = $this->lesson_school->where([
                'lesson_school_chapter' => $req['val'][0]
            ])->first();

            if ($ex) {
                session()->setFlashdata('msg', 'BAB Pelajaran Sekolah sudah ada.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->lesson_school
                    ->set('lesson_school_chapter', $req['val'][0])
                    ->set('lesson_school_updated_by', userdata()['user_id'])
                    ->where('lesson_school_chapter', $req['id'])
                    ->update();
    
                $sts = $this->lesson_school->error();
                if ($sts['code'] > 0) {
                    logging('error', 'update chapter school failed : ' . $sts['message']);
    
                    session()->setFlashdata('msg', 'BAB Pelajaran Sekolah gagal diubah.');
                    session()->setFlashdata('head', 'Gagal!');
                    session()->setFlashdata('icon', 'error');
                } else {
                    $this->activity->store_log('Materi Pelajaran Sekolah', 'update', 'mengubah judul bab pelajaran "' . htmlspecialchars($req['val'][0]) .'"');
    
                    session()->setFlashdata('msg', 'BAB Pelajaran Sekolah berhasil diubah.');
                    session()->setFlashdata('head', 'Sukses!');
                    session()->setFlashdata('icon', 'success');
                }
            }
        } elseif ($req['type'] == 2) {
            $this->lesson_school
                ->set('lesson_school_chapter', $req['val'][0])
                ->set('lesson_school_subchapter', $req['val'][1])
                ->set('lesson_school_updated_by', userdata()['user_id'])
                ->where('lesson_school_id', $req['id'])
                ->update();
            
            $sts = $this->lesson_school->error();
            if ($sts['code'] > 0) {
                logging('error', 'update topic subchapter school failed : ' . $sts['message']);

                session()->setFlashdata('msg', 'Topik Pelajaran Sekolah gagal diubah.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->activity->store_log('Materi Pelajaran Sekolah', 'update', 'mengubah judul bab pelajaran "' . htmlspecialchars($req['val'][0]) .'"');

                session()->setFlashdata('msg', 'Topik Pelajaran Sekolah berhasil diubah.');
                session()->setFlashdata('head', 'Sukses!');
                session()->setFlashdata('icon', 'success');
            }
        } elseif ($req['type'] == 3) {
            $runnum = $this->lesson_school
                ->selectMax('lesson_school_order_child')
                ->where('lesson_school_school_id', userdata()['school_id'])
                ->where('lesson_school_teacher_id', userdata()['id_profile'])
                ->where('lesson_school_subject_id', $req['val'][1])
                ->where('lesson_school_grade', $req['val'][2])
                ->where('lesson_school_school_year_id', $req['val'][4])
                ->where('lesson_school_parent_id', $req['id'])
                ->where('lesson_school_status < 9')
                ->first();

            $arr_ins = [
                'lesson_school_school_id' => userdata()['school_id'],
                'lesson_school_teacher_id' => userdata()['id_profile'],
                'lesson_school_subject_id' => $req['val'][1],
                'lesson_school_grade' => $req['val'][2],
                'lesson_school_school_year_id' => $req['val'][4],
                'lesson_school_chapter' => htmlspecialchars($req['val'][3]),
                'lesson_school_created_by' => userdata()['user_id'],
                'lesson_school_status' => 1,
                'lesson_school_parent_id' => $req['id'],
            ];
            if ($req['val'][0] == 1) {
                $arr_ins['lesson_school_lesson_additional_id'] = $req['val'][5];
            } elseif ($req['val'][0] == 2) {
                $arr_ins['lesson_school_lesson_standart_id'] = $req['val'][5];
            } else {
                $arr_ins['lesson_school_lesson_shared_id'] = $req['val'][5];
            }

            $chk = $this->lesson_school
                ->where($arr_ins)
                ->first();

            if (empty($chk)) {
                $arr_ins['lesson_school_order_child'] = $runnum['lesson_school_order_child'] + 1;
                $this->lesson_school->insert($arr_ins);
                $sts = $this->lesson_school->error();
                if ($sts['code'] > 0) {
                    logging('error', 'add chapter school failed : ' . $sts['message']);

                    session()->setFlashdata('msg', 'Topik Pelajaran Sekolah gagal ditambahkan.');
                    session()->setFlashdata('head', 'Gagal!');
                    session()->setFlashdata('icon', 'error');
                } else {
                    $this->activity->store_log('Materi Pelajaran Sekolah', 'insert', 'menambahkan topik "'.$req['val'][6].'" pada bab "' . htmlspecialchars($req['val'][3]) .'"');
                    session()->setFlashdata('msg', 'Topik Pelajaran Sekolah berhasil ditambahkan.');
                    session()->setFlashdata('head', 'Sukses!');
                    session()->setFlashdata('icon', 'success');
                }
            }

        } elseif ($req['type'] == 4) {
            $ex = $this->lesson_school->where([
                'lesson_school_school_id' => userdata()['school_id'],
                'lesson_school_school_year_id' => school_year()['id'],
                'lesson_school_teacher_id' => userdata()['id_profile'],
                'lesson_school_subject_id' => $req['val'][1],
                'lesson_school_grade' => $req['val'][2],
                'lesson_school_chapter' => htmlspecialchars($req['val'][0]),
                'lesson_school_status' => 1,
            ])->first();

            if ($ex) {
                session()->setFlashdata('msg', 'BAB Pelajaran Sekolah sudah ada.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $runnum = $this->lesson_school
                    ->select('lesson_school_chapter')
                    ->selectMax('lesson_school_order_parent')
                    ->where('lesson_school_school_id', userdata()['school_id'])
                    ->where('lesson_school_school_year_id', school_year()['id'])
                    ->where('lesson_school_teacher_id', userdata()['id_profile'],)
                    ->where('lesson_school_subject_id', $req['val'][1])
                    ->where('lesson_school_grade', $req['val'][2])
                    ->where('lesson_school_status < 9')
                    ->where('lesson_school_parent_id', 0)
                    ->first();
    
                $arr_ins = [
                    'lesson_school_school_id' => userdata()['school_id'],
                    'lesson_school_school_year_id' => school_year()['id'],
                    'lesson_school_teacher_id' => userdata()['id_profile'],
                    'lesson_school_subject_id' => $req['val'][1],
                    'lesson_school_grade' => $req['val'][2],
                    'lesson_school_chapter' => htmlspecialchars($req['val'][0]),
                    'lesson_school_created_by' => userdata()['user_id'],
                    'lesson_school_status' => 1,
                    'lesson_school_order_parent' => $runnum['lesson_school_order_parent'] + 1
                ];
    
                if ($runnum['lesson_school_chapter'] != htmlspecialchars($req['val'][0])) {
                    $this->lesson_school->insert($arr_ins);
                    $sts = $this->lesson_school->error();
                    if ($sts['code'] > 0) {
                        logging('error', 'insert chapter school failed : ' . $sts['message']);
    
                        session()->setFlashdata('msg', 'BAB Pelajaran Sekolah gagal dibuat.');
                        session()->setFlashdata('head', 'Gagal!');
                        session()->setFlashdata('icon', 'error');
                    } else {
                        $this->activity->store_log('Materi Pelajaran Sekolah', 'insert', 'menambah judul bab pelajaran "' . htmlspecialchars($req['val'][0]) .'"');
    
                        session()->setFlashdata('msg', 'BAB Pelajaran Sekolah berhasil dibuat.');
                        session()->setFlashdata('head', 'Sukses!');
                        session()->setFlashdata('icon', 'success');
                    }
                }
            }

        } else if ($req['type'] == -1) {
            $ids = $req['val'][1];
            $sort = $req['val'][0];
            
            $upp = [];
            for ($i=0; $i < count($ids); $i++) { 
                $this->lesson_school
                    ->set('lesson_school_order_parent', $sort[$i])
                    ->set('lesson_school_updated_by', userdata()['user_id'])
                    ->where('lesson_school_id', $ids[$i])
                    ->update();       
                $arr_sts = $this->lesson_school->error();
                $upp[] = $arr_sts['code'] < 1;
            }

            if (in_array(0, $upp)) {
                // $sts = ['code' => 1];
                logging('error', 'sort chapter school failed : ');

                session()->setFlashdata('msg', 'BAB Pelajaran gagal diurutkan.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->activity->store_log('Materi Pelajaran Sekolah', 'update', 'mengurutkan bab pelajaran');

                // $sts = ['code' => 1];
                session()->setFlashdata('msg', 'BAB Pelajaran berhasil diurutkan.');
                session()->setFlashdata('head', 'Sukses!');
                session()->setFlashdata('icon', 'success');
            }
        } else if ($req['type'] == -2) {
            $ids = $req['val'][1];
            $sort = $req['val'][0];
            
            $upp = [];
            for ($i=0; $i < count($ids); $i++) { 
                $this->lesson_school
                    ->set('lesson_school_order_child', $sort[$i])
                    ->set('lesson_school_updated_by', userdata()['user_id'])
                    ->where('lesson_school_id', $ids[$i])
                    ->update();   
                $arr_sts = $this->lesson_school->error();    
                $upp[] = $arr_sts['code'] < 1;
            }

            if (in_array(0, $upp)) {
                // $sts = ['code' => 1];
                logging('error', 'sort topic school failed : ');

                session()->setFlashdata('msg', 'Topik Pelajaran gagal diurutkan.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->activity->store_log('Materi Pelajaran Sekolah', 'update', 'mengurutkan topik pelajaran pada bab "' .$req['val'][2] .'"');

                // $sts = ['code' => 1];
                session()->setFlashdata('msg', 'Topik Pelajaran berhasil diurutkan.');
                session()->setFlashdata('head', 'Sukses!');
                session()->setFlashdata('icon', 'success');
            }
        }


        echo json_encode($sts);
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
                ->where('lesson_additional_school_id', $school)
                ->where('lesson_additional_teacher_id', $teacher)
                ->where('lesson_additional_grade', $grade)
                ->where('lesson_additional_subject_id', $subject)
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
                ->where('lesson_standart_subject_id', $subject)
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
                ->where('lesson_additional_subject_id', $subject)
                ->where('lesson_additional_chapter', $v['text'])
                ->where('lesson_additional_subchapter != ""')
                ->where('lesson_additional_status < 9')
                ->findAll();

            $public[$k]['nodes'] = $sub_chapter;
        }
        $result = array(
            array('nodes' => $private, 'text' => 'Materi Saya', 'ind' => 1),
            array('nodes' => $standard, 'text' => 'Materi Standar', 'ind' => 2),
            array('nodes' => $public, 'text' => 'Materi Publik', 'ind' => 3),
        );

        echo json_encode($result);
    }

    public function grab_child_sort()
    {
        $req = $this->request->getVar();
        $sort = $this->lesson_school
            ->select('
                lesson_school_id,
                lesson_school_chapter, 
                lesson_additional_subchapter, 
                lesson_standart_subchapter, 
                lesson_school_order_child
            ')
            ->join('lms_lesson_additional', 'lesson_additional_id=lesson_school_lesson_additional_id or lesson_additional_id=lesson_school_lesson_shared_id ', 'left')
            ->join('lms_lesson_standart', 'lesson_standart_id=lesson_school_lesson_standart_id', 'left')
            ->where('lesson_school_school_id', userdata()['school_id'])
            ->where('lesson_school_parent_id', $req['id'])
            ->where('lesson_school_grade', $req['grade'])
            ->where('lesson_school_status < 9')
            ->orderBy('lesson_school_order_child')
            ->findAll();
        
        echo json_encode($sort);
    }

    public function grab_parent_sort()
    {
        $req = $this->request->getVar();

        $data = $this->lesson_school
            ->select('lesson_school_id, lesson_school_chapter, lesson_school_order_parent')
            ->where('lesson_school_school_id', userdata()['school_id'])
            ->where('lesson_school_teacher_id', userdata()['id_profile'])
            ->where('lesson_school_parent_id', 0)
            ->where('lesson_school_grade', $req['grade'])
            ->where('lesson_school_status < 9')
            ->orderBy('lesson_school_order_parent')
            ->findAll();

        echo json_encode($data);
    }

    private function get_std_lesson($param)
    {
        return $this->lesson_standart
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
            ->where('lesson_standart_id', $param)
            ->where('lesson_standart_status < 9')
            ->first();
    }

    private function get_add_lesson($param)
    {
        return $this->lesson_additional
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
            ->where('lesson_additional_id', $param)
            ->where('lesson_additional_status < 9')
            ->first();
    }

    private function get_shr_lesson($param)
    {
        return $this->lesson_additional
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
            ->where('lesson_additional_id', $param)
            ->where('lesson_additional_status < 9')
            ->first();
    }

    public function remove_content()
    {
        $req = $this->request->getVar();

        $sts = [];
        if ($req['type'] == 1) {
            $this->lesson_school
                ->where('lesson_school_id', $req['id'])
                ->orWhere('lesson_school_parent_id', $req['id'])
                ->set('lesson_school_updated_by', userdata()['user_id'])
                ->set('lesson_school_status', 9)
                ->update();

            $sts = $this->lesson_school->error();
            if ($sts['code'] > 0) {
                session()->setFlashdata('msg', 'BAB Pelajaran gagal dihapus.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->activity->store_log('Materi Pelajaran Sekolah', 'delete', 'menghapus bab pelajaran "' . $req['chap'] .'" beserta seluruh topik pelajaran.');

                session()->setFlashdata('msg', 'BAB Pelajaran berhasil dihapus.');
                session()->setFlashdata('head', 'Sukses!');
                session()->setFlashdata('icon', 'success');
            }
        } elseif ($req['type'] == 2) {
            $this->lesson_school
                ->where('lesson_school_id', $req['id'])
                ->set('lesson_school_updated_by', userdata()['user_id'])
                ->set('lesson_school_status', 9)
                ->update();

            $sts = $this->lesson_school->error();
            if ($sts['code'] > 0) {
                session()->setFlashdata('msg', 'Topik Pelajaran gagal dihapus.');
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'error');
            } else {
                $this->activity->store_log('Materi Pelajaran Sekolah', 'delete', 'menghapus topik pelajaran "' . $req['subchap'] .'" pada bab "'. $req['chap'] .'"');

                session()->setFlashdata('msg', 'Topik Pelajaran berhasil dihapus.');
                session()->setFlashdata('head', 'Sukses!');
                session()->setFlashdata('icon', 'success');
            }
        }

        echo json_encode($sts);
    }


    // BEGIN STUDENT FUNCTION
    public function s_index()
    {
        $data["title"] = 'Materi Sekolah';
        $data["page"] = 'Self Study';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Sekolah',
        ];


        // $subs = [];
        // // if (isset(school_year()['id'])) {
        //     $mysubs = $this->teacher_subject
        //         ->select('teacher_assign_id, teacher_assign_grade, subject_id, subject_name')
        //         ->join('master_subject', 'teacher_assign_subject_id=subject_id', 'left')
        //         ->where('teacher_assign_school_id', userdata()['school_id'])
        //         ->where('teacher_assign_teacher_id', userdata()['id_profile'])
        //         ->where('teacher_assign_status < 9')
        //         ->where('teacher_assign_school_year_id', school_year()['id'])
        //         ->orderBy('teacher_assign_grade')
        //         ->findAll();
       
        //     foreach ($mysubs as $k => $v) {
        //         $subs[$v['subject_id']]['subj_id'] = $v['subject_id'];
        //         $subs[$v['subject_id']]['subj_name'] = $v['subject_name'];
        //         $subs[$v['subject_id']]['grade'][$v['teacher_assign_grade']] = $v['teacher_assign_grade'];
        //     }
        // // }


        // $data['mysubs'] = $subs;
        return view("learningms/lesson_school/index_s", $data);
    }

    public Function s_first_page()
    {
       
        if (isset(school_year()['id'])) {
            $my_group = student_group();
            $total_chapter = $this->lesson_school
                ->select('count(*)')
                ->where('lesson_school_status < 9')
                ->where('lesson_school_grade', $my_group['grade'])
                ->where('lesson_school_school_id', userdata()['school_id'])
                ->where('lesson_school_school_year_id', school_year()['id'])
                ->groupBy('lesson_school_chapter, lesson_school_grade')
                ->findAll();
            $total_subchapter = $this->lesson_school
                ->select('lesson_school_lesson_standart_id, lesson_school_lesson_additional_id, lesson_school_lesson_shared_id')
                ->where('lesson_school_status < 9')
                ->where('lesson_school_grade', $my_group['grade'])
                ->where('lesson_school_school_id', userdata()['school_id'])
                ->where('lesson_school_school_year_id', school_year()['id'])
                ->findAll();
    
            $c = 0;
            foreach ($total_subchapter as $v) {
                if ($v['lesson_school_lesson_standart_id'] > 0 || $v['lesson_school_lesson_additional_id'] > 0 || $v['lesson_school_lesson_shared_id'] > 0) {
                    $c++;
                }
            }

            $res = [
                't_chap' => count($total_chapter),
                't_subchap' => $c,
            ];
        } else {
            $res = [
                't_chap' => 0,
                't_subchap' => 0,
            ];
        }

        echo json_encode($res);
    }

    public function s_list_subject()
    {
        $my_group = student_group();
        $sub_list = $this->lesson_school->student_list_subject($my_group['grade'], $my_group['group_id']);

        $data = [];
        foreach ($sub_list as $k => $v) {
            $deg = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : '';
            $lists = '
                <div class="d-flex justify-content-between rounded">
                    <div class="d-flex align-items-start">
                        <a href="'.base_url().'student/lesson/school/view-content/'.$v['subject_id'].'/'.$v['lesson_school_grade'].'" class="btn btn-primary pl-10">Lihat Materi</a>
                        <div class="flex-grow-1 me-2 mx-10">
                            <h3 class="mb-1">'.$v['subject_name'].'</h3>
                            <span class="text-gray-700 fw-semibold d-block">BAB: '.$v['total_chapter'].' | Topik: '.$v['total_subchapter'].'</span>
                        </div>
                    </div>

                    <div class="additional-info d-flex align-items-center">
                        <div class="d-flex align-items-end flex-column">
                            <span class="text-gray-700 fw-semibold">Guru: '.$v['teacher_first_name'].' '.$v['teacher_last_name'] . $deg . '</span>
                        </div>
                    </div>
                </div>
            ';

            $data[] = [
                'id' => $v['lesson_school_id'],
                'lists' => $lists
            ];
        }

        echo (json_encode($data));
    }

    public function s_view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'] . ' - Kelas ' . $grade;
        $data["page"] = 'Self Study';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => 'Belajar Mandiri',
            '/student/lesson/school' => 'Materi Sekolah',
            '##' => $subs['subject_name'] . ' - Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $chapter = $this->lesson_school
            ->select('
                lesson_school_id, 
                lesson_school_chapter chapter, 
                lesson_school_lesson_additional_id add, 
                lesson_school_lesson_standart_id std,
                lesson_school_lesson_shared_id shr,
                lesson_school_parent_id,
                lesson_school_order_child,
                lesson_school_order_parent
            ')
            // ->where('lesson_school_teacher_id', userdata()['id_profile'])
            ->where('lesson_school_status < 9')
            ->where('lesson_school_subject_id', $subject)
            ->where('lesson_school_grade', $grade)
            ->orderBy('lesson_school_order_parent', 'desc')
            ->findAll();
        
        $result = array();
        foreach ($chapter as $val) {
            
            $rr = [];
            if ($val['add'] > 0 || $val['std'] > 0 || $val['shr'] > 0) {
                if ($val['add'] > 0) {
                    $rr = $this->get_add_lesson($val['add']);
                } elseif ($val['std'] > 0) {
                    $rr = $this->get_std_lesson($val['std']);
                } else {
                    $rr = $this->get_shr_lesson($val['shr']);
                }
            }

            if(count($rr) > 0){
                $rr['order'] = $val['lesson_school_order_child'];
                $rr['parent_id'] = $val['lesson_school_parent_id'];
                $rr['lesson_id'] = $val['lesson_school_id'];
                $result[$val['chapter']]['sub_chapter'][$val['lesson_school_order_child']] = $rr;
            }
            $result[$val['chapter']]['lesson_school_chapter'] = $val['chapter'];
            $result[$val['chapter']]['lesson_school_id'] = $val['lesson_school_id'];
            $result[$val['chapter']]['lesson_school_parent_id'] = $val['lesson_school_parent_id'];
            $result[$val['chapter']]['lesson_school_order_parent'] = $val['lesson_school_order_parent'];
        }
        
        $chp = [];
        foreach ($result as $k => $v) {
            if (isset($v['sub_chapter'])) {
                $sc = $v['sub_chapter'];
                ksort($sc);

                $ii = 0;
                foreach ($v['sub_chapter'] as $key => $val) {
                    if ($ii < 1) {
                        $pid = $val['parent_id'];
                        $odr = $this->lesson_school
                            ->where('lesson_school_id', $pid)
                            ->first();
                    }
                    $ii++;
                }
                $v['sub_chapter'] = $sc;
                $chp[$odr['lesson_school_order_parent']] = $v;
            } else {
                $chp[$v['lesson_school_order_parent']] = $v;
            }
        }

        ksort($chp);
        $data['chapters'] = $chp;

        return view("learningms/lesson_school/content", $data);
    }
}