<?php

namespace App\Controllers\LearningMS\Assessment;

use App\Controllers\BaseController;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\QuestionBank\PublicQuestionBankModel;
use App\Models\Assessment\AssessmentModel;
use App\Models\Assessment\AssessmentResultModel;
use App\Models\Management\TeachingSubjectsModel;
use App\Models\Management\StudentInGroupModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use App\Models\Activities\ActivityModel;
use App\Models\Result\ResultGradesModel;
use App\Models\System\NotificationLMSModel;
use App\Models\System\ReadNotificationLMSModel;
use \Datetime;
use Ramsey\Uuid\Uuid;
use PDO;

class Assessment extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $teacher_subject;
    protected $question_bank;
    protected $question_bank_standart;
    protected $question_bank_public;
    protected $teacher;
    protected $subject;
    protected $assessment;
    protected $assessment_result;
    protected $result_grades;
    protected $student;
    protected $in_group;
    protected $activity;
    protected $notification;
    protected $notification_read;

    public function __construct()
    {
        $this->title = "Penilaian";
        $this->page = "Assessment";
        $this->sidebar = "Draft_Assessment";
        $this->question_bank = new QuestionBankModel();
        $this->question_bank_standart = new StandartQuestionBankModel();
        $this->question_bank_public = new PublicQuestionBankModel();
        $this->teacher_subject = new TeachingSubjectsModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->assessment = new AssessmentModel();
        $this->assessment_result = new AssessmentResultModel();
        $this->result_grades = new ResultGradesModel();
        $this->in_group = new StudentInGroupModel();
        $this->activity = new ActivityModel();
        $this->notification = new NotificationLMSModel();
        $this->notification_read = new ReadNotificationLMSModel();
    }

    // BEGIN TEACHER FUNCTION
    public function index()
    {
        $data["title"] = 'Tambah Penilaian';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Add_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Tambah Penilaian',
        ];

        $te_duty = $this->teacher_subject->get_teacher_duty(userdata()['id_profile']);

        $list_grade = get_list('grade')[school_level(userdata()['school_id'])];
        $grade = $group = $subs = $sub = [];
        foreach ($te_duty as $k => $v) {
            $sub[$v['subject_id']] = $v['subject_name'];

            $subs[$v['subject_id']]['subjs'] = $v['subject_name'];
            $subs[$v['subject_id']]['subjs_id'] = $v['subject_id'];
            $subs[$v['subject_id']]['grade'][$v['student_group_grade']] = 'Kelas ' . $list_grade[$v['student_group_grade']];


            $group[$v['student_group_id']] = $v['student_group_name'];
            $grade[$v['student_group_grade']]['grade'] = 'Kelas ' . $list_grade[$v['student_group_grade']];
            $grade[$v['student_group_grade']]['subjs'][$v['subject_id']] = $v['subject_name'];
        }

        $data['sub'] = $sub;
        $data['grd'] = $list_grade;

        $data['my_duty'] = $subs;
        $data['religion'] = get_list('religion');

        return view("learningms/assessment/index", $data);
    }

    public function get_list_religion()
    {
        echo json_encode(get_list('religion'));
    }

    public function data_option()
    {
        $req = $this->request->getVar();

        $ex = $this->teacher_subject
            ->select('student_group_id, student_group_name')
            ->join('manage_student_in_group', 'teaching_subjects_student_group_id = student_in_group_student_group_id')
            ->join('master_student_group', 'student_group_id = student_in_group_student_group_id')
            ->join('master_subject', 'subject_id = teaching_subjects_subject_id')
            ->where('teaching_subjects_school_id', userdata()['school_id'])
            ->where('teaching_subjects_school_year_id', school_year()['id'])
            ->where('teaching_subjects_teacher_id', userdata()['id_profile'])
            ->where('subject_id', $req['subs'])
            ->where('student_in_group_grade', $req['grad'])
            ->where('teaching_subjects_status < 9')
            ->groupBy('student_group_id')
            ->findAll();

        $arr_group = [];
        if ($ex) {
            foreach ($ex as $k => $v) {
                $arr_group[$k]['id'] = $v['student_group_id'];
                $arr_group[$k]['name'] = $v['student_group_name'];
            }

            echo json_encode($arr_group);
        } else {
            echo json_encode(false);
        }
    }

    public function view_content($subject, $grade)
    {
        $subs = $this->subject->where('subject_id', $subject)->first();

        $data["title"] = $subs['subject_name'] . ' - Kelas ' . $grade;
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/question-bank/additional' => 'Bank Soal Saya',
            '##' => $subs['subject_name'] . ' - Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title')
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_status < 9')
            ->where('question_bank_subject_id', $subject)
            ->where('question_bank_grade', $grade)
            ->where('question_bank_parent_id', 0)
            ->findAll();

        foreach ($question as $k => $v) {
            $child = $this->question_bank
                ->select('question_bank_id, question_bank_parent_id')
                ->where('question_bank_parent_id', $v['question_bank_id'])
                ->where('question_bank_status < 9')
                ->findAll();
            $question[$k]['child'] = array_chunk($child, 5);
        }

        $data['questions'] = $question;
        $data['quest_type'] = get_list('question_type');

        $data['teachers'] = $this->teacher
            ->select('teacher_id, teacher_first_name, teacher_last_name, teacher_degree')
            ->where('teacher_school_id', userdata()['school_id'])
            ->where('teacher_id <> ' . userdata()['id_profile'])
            ->findAll();

        return view("learningms/question_bank_additional/content", $data);
    }

    public function view_question_bank()
    {
        $req = $this->request->getVar();

        $std = $this->question_bank_standart
            ->select('question_bank_standart_id as id, question_bank_standart_title as title, "std" as source')
            ->where('question_bank_standart_subject_id', $req['subj'])
            ->where('question_bank_standart_grade', $req['grad'])
            ->where('question_bank_standart_parent_id', 0)
            ->where('question_bank_standart_status < 9')
            ->findAll();

        $me = $this->question_bank->select('question_bank_id as id, question_bank_title as title, "me" as source')
            ->where('question_bank_subject_id', $req['subj'])
            ->where('question_bank_grade', $req['grad'])
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_parent_id', 0)
            ->where('question_bank_status < 9')
            ->findAll();

        $pub = $this->question_bank_public->get_list_title(userdata()['id_profile'], [$req['subj']], [$req['grad']]);

        foreach ($std as $k => $v) {
            $ch_std = $this->question_bank_standart
                ->select('question_bank_standart_id as id')
                ->where('question_bank_standart_parent_id', $v['id'])
                ->where('question_bank_standart_status < 9')
                ->findAll();

            $std[$k]['child'] = array_chunk(array_column($ch_std, 'id'), 6);
        }

        foreach ($me as $k => $v) {
            $ch_me = $this->question_bank->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $me[$k]['child'] = array_chunk(array_column($ch_me, 'id'), 6);
        }

        foreach ($pub as $k => $v) {
            $ch_pub = $this->question_bank->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $pub[$k]['child'] = array_chunk(array_column($ch_pub, 'id'), 6);
        }

        $res = [
            'std' => ['head' => 'Bank Soal Standart', 'content' => $std, 'src' => 1],
            'me' => ['head' => 'Bank Soal Saya', 'content' => $me, 'src' => 2],
            'pub' => ['head' => 'Bank Soal Publik', 'content' => $pub, 'src' => 3],
        ];

        echo json_encode([
            'res' => $res,
            'sub_name' => subject_rowid($req['subj'])['subject_name'],
            'grd_name' => get_list('grade')[school_level(userdata()['school_id'])][$req['grad']]
        ]);
    }

    public function get_edit()
    {
        $id = $this->request->getVar('id');

        $select = '
                    assessment_id,
                    assessment_title,
                    assessment_start,
                    assessment_end,
                    assessment_grade,
                    assessment_subject_id,
                    assessment_group,
                    assessment_question_bank_src,
                    assessment_question_bank_id,
                    assessment_duration,
                    assessment_religion,
                    assessment_is_random,
                    assessment_is_autosubmit,
                    assessment_is_prevent_cheat,
                    assessment_is_show_hint,
                    assessment_instruction,
                    subject_name,
                    question_bank_title,
                    question_bank_standart_title,
                ';

        $row = $this->assessment
            ->select($select)
            ->join('master_subject', 'subject_id=assessment_subject_id', 'left')
            ->join('lms_question_bank', 'question_bank_id=assessment_question_bank_id', 'left')
            ->join('lms_question_bank_standart', 'question_bank_standart_id=assessment_question_bank_id', 'left')
            ->where('assessment_id', $id)->first();

        echo json_encode($row);
    }

    public function store_data()
    {
        $req = $this->request->getVar();
        $semester = semester();
        if ($req['type'] == 1) {
            $d = json_decode($req['data']);
            $titlegrade = explode(' - ', $d[13]);
            $should_chk = $this->should_check($d[11], $d[14]);

            $group = [];
            foreach ($d[3] as $k => $v) {
                $group[$k]['id'] = $v->id;
                $group[$k]['group'] = $v->text;
                $group[$k]['checked_all'] = $should_chk;
            }

            if ($req['id'] > 0) {
                $this->assessment->db->transBegin();

                $message = 'Something went wrong!';
                try {
                    $teasub = $this->assessment
                        ->select('assessment_teacher_id teacher, assessment_subject_id subject')
                        ->where('assessment_id', $req['id'])
                        ->where('assessment_status < 9')
                        ->first();

                    $upd = $this->assessment
                        ->where('assessment_id', $req['id'])
                        ->set('assessment_semester', semester())
                        ->set('assessment_title', $d[0])
                        ->set('assessment_start', date('Y-m-d H:i:s', strtotime($d[4] . ':00')))
                        ->set('assessment_end', date('Y-m-d H:i:s', strtotime($d[5] . ':00')))
                        ->set('assessment_duration', $d[6])
                        ->set('assessment_religion', $d[18])
                        ->set('assessment_is_random', $d[7])
                        ->set('assessment_is_autosubmit', $d[9])
                        ->set('assessment_is_prevent_cheat', $d[8])
                        ->set('assessment_is_show_hint', $d[19])
                        ->set('assessment_instruction', $d[10])
                        ->set('assessment_status', $d[15])
                        ->set('assessment_group', json_encode($group))
                        ->set('assessment_updated_by', session()->get('c_id'))
                        ->update();

                    $this->activity->store_log('Penilaian', 'update', 'mengubah penilaian "' . $d[0] . '"');
                    
                    if ($d[15] > 1) {
                        foreach ($group as $k => $v) {
                            $this->notification->store_notification(
                                1,
                                $req['id'],
                                'Penilaian',
                                "Penilaian {$d[0]} mata pelajaran {$titlegrade[0]} telah diterbitkan.",
                                $v['id'],
                            );
                        }
                    }

                    foreach ($group as $k => $v) {
                        $students = $this->in_group->list_for_assessment($v['id'], userdata()['school_id'], $d[18]);

                        $data_exists = [];
                        $data_exists['assessment_result_assessment_id'] = $req['id'];
                        $data_exists['assessment_result_group_id'] = $v['id'];
                        $data_exists['assessment_result_school_id'] = userdata()['school_id'];

                        $this->assessment_result->where($data_exists)->delete();
                        $sts_del = $this->assessment_result->error();

                        if ($sts_del['code'] > 0) {
                            throw new \Exception($sts_del['message']);
                            $message = $sts_del['message'];
                        }

                        $data_exists_gv = [];
                        $data_exists_gv['result_grades_source_id'] = $req['id'];
                        $data_exists_gv['result_grades_group_id'] = $v['id'];
                        $data_exists_gv['result_grades_school_id'] = userdata()['school_id'];
                        $data_exists_gv['result_grades_school_year_id'] = school_year()['id'];
                        // $data_exists_gv['result_grades_semester'] = $semester;

                        $this->result_grades->where($data_exists_gv)->delete();
                        $stsdelgv = $this->result_grades->error();
                        if ($stsdelgv['code'] > 0) {
                            throw new \Exception($stsdelgv['message']);
                            $message = $stsdelgv['message'];
                        }

                        foreach ($students as $key => $val) {
                            $data_res = [];
                            $data_res['assessment_result_id'] = Uuid::uuid4()->toString();
                            $data_res['assessment_result_assessment_id'] = $req['id'];
                            $data_res['assessment_result_school_id'] = userdata()['school_id'];
                            $data_res['assessment_result_school_year_id'] = $d[17];
                            $data_res['assessment_result_semester'] = $semester;
                            $data_res['assessment_result_group_id'] = $v['id'];
                            $data_res['assessment_result_student_id'] = $val['student_in_group_student_id'];
                            $data_res['assessment_result_is_checked'] = $should_chk;

                            $this->assessment_result->insert($data_res);
                            $sts_replace = $this->assessment_result->error();

                            if ($sts_replace['code'] > 0) {
                                throw new \Exception($sts_replace['message']);
                                $message = $sts_replace['message'];
                            }

                            $resval = [];
                            $resval['result_grades_id'] = Uuid::uuid4()->toString();
                            $resval['result_grades_school_id'] = userdata()['school_id'];
                            $resval['result_grades_school_year_id'] = school_year()['id'];
                            $resval['result_grades_semester'] = $semester;
                            $resval['result_grades_group_id'] = $v['id'];
                            $resval['result_grades_student_id'] = $val['student_in_group_student_id'];
                            $resval['result_grades_value_type'] = 2;
                            $resval['result_grades_source_id'] = $req['id'];
                            $resval['result_grades_source_title'] = $d[0];
                            $resval['result_grades_teacher_id'] = $teasub['teacher'];
                            $resval['result_grades_subject_id'] = $teasub['subject'];

                            $this->result_grades->insert($resval);
                            $stsrv = $this->result_grades->error();
                            if ($stsrv['code'] > 0) {
                                throw new \Exception($stsrv['message']);
                                $message = $stsrv['message'];
                            }
                        }
                    }
                    
                    $this->assessment->db->transCommit();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => $upd,
                        'msg' => $upd ? 'Penilaian berhasil diubah' : 'Penilaian gagal diubah',
                        'icn' => $upd ? 'success' : 'error',
                    ];
                } catch (\Throwable $th) {
                    logging('error', 'update assessment failed : ' . $th->getMessage());
                    $this->assessment->db->transRollback();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => $message,
                        'icn' => 'error',
                    ];
                }

                echo json_encode($res);
            } else {
                $this->assessment->db->transBegin();

                $message = 'Something went wrong!';
                try {
                    $data = [
                        'assessment_school_id' => userdata()['school_id'],
                        'assessment_school_year_id' => $d[17],
                        'assessment_semester' => semester(),
                        'assessment_teacher_id' => userdata()['id_profile'],
                        'assessment_grade' => $d[2],
                        'assessment_subject_id' => $d[1],
                        'assessment_group' => json_encode($group),
                        'assessment_title' => $d[0],
                        'assessment_question_bank_id' => $d[11],
                        'assessment_question_bank_src' => $d[14],
                        'assessment_start' => date('Y-m-d H:i:s', strtotime($d[4] . ':00')),
                        'assessment_end' => date('Y-m-d H:i:s', strtotime($d[5] . ':00')),
                        'assessment_duration' => $d[6],
                        'assessment_religion' => $d[18],
                        'assessment_is_random' => $d[7],
                        'assessment_is_autosubmit' => $d[9],
                        'assessment_is_prevent_cheat' => $d[8],
                        'assessment_is_show_hint' => $d[19],
                        'assessment_instruction' => $d[10],
                        'assessment_status' => $d[15],
                        'assessment_created_by' => session()->get('c_id'),
                    ];
                    $this->assessment->insert($data);
                    $this->activity->store_log('Penilaian', 'insert', 'menambah penilaian "' . $d[0] . '"');
 
                    if ($d[15] > 1) {
                        foreach ($group as $k => $v) {
                            $this->notification->store_notification(
                                1,
                                $this->assessment->getInsertID(),
                                'Penilaian',
                                "Penilaian {$d[0]} mata pelajaran {$titlegrade[0]} telah diterbitkan.",
                                $v['id'],
                            );
                        }
                    }

                    foreach ($group as $k => $v) {
                        $students = $this->in_group->list_for_assessment($v['id'], userdata()['school_id'], $d[18]);

                        foreach ($students as $key => $val) {
                            $data_res = [
                                'assessment_result_id' => Uuid::uuid4()->toString(),
                                'assessment_result_assessment_id' => $this->assessment->getInsertID(),
                                'assessment_result_school_id' => userdata()['school_id'],
                                'assessment_result_school_year_id' => $d[17],
                                'assessment_result_semester' => $semester,
                                'assessment_result_group_id' => $v['id'],
                                'assessment_result_student_id' => $val['student_in_group_student_id'],
                                'assessment_result_is_checked' => $should_chk
                            ];

                            $this->assessment_result->insert($data_res);
                            $inss = $this->assessment_result->error();
                            if ($inss['code'] > 0) {
                                throw new \Exception($inss['message']);
                                $message = $inss['message'];
                            }

                            $resval = [];
                            $resval['result_grades_id'] = Uuid::uuid4()->toString();
                            $resval['result_grades_school_id'] = userdata()['school_id'];
                            $resval['result_grades_school_year_id'] = school_year()['id'];
                            $resval['result_grades_semester'] = $semester;
                            $resval['result_grades_group_id'] = $v['id'];
                            $resval['result_grades_student_id'] = $val['student_in_group_student_id'];
                            $resval['result_grades_value_type'] = 2;
                            $resval['result_grades_source_id'] = $this->assessment->getInsertID();
                            $resval['result_grades_source_title'] = $d[0];
                            $resval['result_grades_teacher_id'] = userdata()['id_profile'];
                            $resval['result_grades_subject_id'] = $d[1];

                            $this->result_grades->insert($resval);
                            $stsrv = $this->result_grades->error();
                            if ($stsrv['code'] > 0) {
                                throw new \Exception($stsrv['message']);
                                $message = $stsrv['message'];
                            }
                        }
                    }

                    $this->assessment->db->transCommit();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => 'Penilaian berhasil ditambahkan',
                        'icn' => 'success'
                    ];
                    echo json_encode($res);
                } catch (\Exception $e) {

                    logging('error', 'add assessment failed : ' . $e->getMessage());
                    $this->assessment->db->transRollback();
                    $res = [
                        'typ' => $req['type'],
                        'sts' => true,
                        'msg' => $message,
                        'icn' => 'error',
                    ];
                    echo json_encode($res);
                }
            }
        } else if ($req['type'] == 2) {
            $success = true;
            $itrue = $ifalse = 0;
            $message = 'Something went wrong!';
            $ecode = 0;

            $this->assessment->db->transBegin();
            try {
                foreach ($req['id'] as $k => $v) {
                    if ($req['data'] == 1 || $req['data'] == 2 || $req['data'] == 9) {
                        $this->assessment
                            ->where('assessment_id', $v)
                            ->set('assessment_status', $req['data'])
                            ->set('assessment_updated_by', session()->get('c_id'))
                            ->update();


                        if ($req['data'] == 2) {
                            $r = $this->assessment->getWhere(['assessment_id' => $v])->getRowArray();
                            $s = $this->subject->getWhere(['subject_id' => $r['assessment_subject_id']])->getRowArray();
                            
                            foreach (json_decode($r['assessment_group']) as $key => $val) {
                                $this->notification->store_notification(
                                    1,
                                    $v,
                                    'Penilaian',
                                    "Penilaian {$r['assessment_title']} mata pelajaran {$s['subject_name']} telah diterbitkan.",
                                    $val->id,
                                );
                            }
                        } else {
                             $prm = [
                                'notification_lms_school_id' => userdata()['school_id'],
                                'notification_lms_source_type' => 1,
                                'notification_lms_source_id' => $v,
                            ];

                            $this->notification->where($prm)->delete();
                        }
                    } else if ($req['data'] == 3 || $req['data'] == 4) {
                        $shint = $req['data'] == 3 ? 1 : 0;
                        $this->assessment
                            ->where('assessment_id', $v)
                            ->set('assessment_is_show_hint', $shint)
                            ->set('assessment_updated_by', session()->get('c_id'))
                            ->update();
                    } else if ($req['data'] == 5 || $req['data'] == 6) {
                        $shint = $req['data'] == 5 ? 1 : 0;
                        $this->assessment
                            ->where('assessment_id', $v)
                            ->set('assessment_is_show_explain', $shint)
                            ->set('assessment_updated_by', session()->get('c_id'))
                            ->update();
                    } else if ($req['data'] == 7 || $req['data'] == 8) {
                        $shint = $req['data'] == 7 ? 1 : 0;
                        $this->assessment
                            ->where('assessment_id', $v)
                            ->set('assessment_is_show_right_answer', $shint)
                            ->set('assessment_updated_by', session()->get('c_id'))
                            ->update();
                    } else if ($req['data'] == 10 || $req['data'] == 11) {
                        $shint = $req['data'] == 10 ? 1 : 0;
                        $this->assessment
                            ->where('assessment_id', $v)
                            ->set('assessment_is_random', $shint)
                            ->set('assessment_updated_by', session()->get('c_id'))
                            ->update();
                    }

                    $sts_assess = $this->assessment->error();
                    if ($sts_assess['code'] > 0) {
                        logging('error', 'transaction assessment failed : ' . $sts_assess['message']);
                        $message = $sts_assess['message'];
                        $ecode = $sts_assess['code'];


                        $ifalse++;
                    } else {
                        if ($req['data'] == 2) {
                            $this->activity->store_log('Penilaian', 'publish', 'menerbitkan penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 1) {
                            $this->activity->store_log('Penilaian', 'unpublish', 'membatalkan penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 9) {
                            $this->activity->store_log('Penilaian', 'delete', 'menghapus penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 3) {
                            $this->activity->store_log('Penilaian', 'update', 'menampilkan petunjuk pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 4) {
                            $this->activity->store_log('Penilaian', 'update', 'menyembunyikan petunjuk pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 5) {
                            $this->activity->store_log('Penilaian', 'update', 'menampilkan penjelasan pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 6) {
                            $this->activity->store_log('Penilaian', 'update', 'menyembunyikan penjelasan pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 7) {
                            $this->activity->store_log('Penilaian', 'update', 'menampilkan jawaban benar pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 8) {
                            $this->activity->store_log('Penilaian', 'update', 'menyembunyikan jawaban benar pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 10) {
                            $this->activity->store_log('Penilaian', 'update', 'mengacak soal pada penilaian "' . $req['title'][$k] . '"');
                        } else if ($req['data'] == 11) {
                            $this->activity->store_log('Penilaian', 'update', 'membatalkan acak soal pada penilaian "' . $req['title'][$k] . '"');
                        }

                        $itrue++;
                    }


                    if ($req['data'] == 9) {
                        $data_exists = [];
                        $data_exists['assessment_result_assessment_id'] = $v;
                        $data_exists['assessment_result_school_id'] = userdata()['school_id'];

                        $this->assessment_result->where($data_exists)->delete();
                        // $query = $this->assessment_result->getLastQuery();

                        $sts_upd = $this->assessment_result->error();

                        if ($sts_upd['code'] > 0) {
                            logging('error', 'reset assessment result failed : ' . $sts_assess['message']);
                            $message = $sts_upd['message'];
                            $ecode = $sts_upd['code'];
                            throw new \Exception($sts_upd['message']);
                        }

                        $data_exists_gv = [];
                        $data_exists_gv['result_grades_source_id'] = $req['id'];
                        $data_exists_gv['result_grades_school_id'] = userdata()['school_id'];
                        $data_exists_gv['result_grades_school_year_id'] = school_year()['id'];
                        // $data_exists_gv['result_grades_semester'] = $semester;

                        $this->result_grades->where($data_exists_gv)->delete();
                        $stsdelgv = $this->result_grades->error();
                        if ($stsdelgv['code'] > 0) {
                            logging('error', 'reset result grades failed : ' . $sts_assess['message']);
                            throw new \Exception($stsdelgv['message']);
                            $message = $stsdelgv['message'];
                        }
                    }
                }
                $this->assessment->db->transCommit();
            } catch (\Throwable $th) {
                logging('error', 'transaction result failed : ' . $th->getMessage());
                $this->assessment->db->transRollback();
                $success = false;
            }

            if ($req['data'] == 2) {
                $msg = "di terbitkan";
            } else if ($req['data'] == 1) {
                $msg = 'di batalkan';
            } else if ($req['data'] == 9) {
                $msg = 'di hapus';
            } else if ($req['data'] == 3) {
                $msg = 'merubah status tampilkan petunjuk soal';
            } else if ($req['data'] == 4) {
                $msg = 'merubah status sembunyikan petunjuk soal';
            } else if ($req['data'] == 5) {
                $msg = 'merubah status tampilkan penjelasan soal';
            } else if ($req['data'] == 6) {
                $msg = 'merubah status sembunyikan penjelasan soal';
            } else if ($req['data'] == 7) {
                $msg = 'merubah status tampilkan jawaban benar';
            } else if ($req['data'] == 8) {
                $msg = 'merubah status sembunyikan jawaban benar';
            } else if ($req['data'] == 10) {
                $msg = 'acak soal';
            } else if ($req['data'] == 11) {
                $msg = 'batalkan acak soal';
            }

            if ($ecode > 0) {
                logging('error', 'transaction '.$req['data'].' failed : ' . $message);
                $res = [
                    'typ' => $req['type'],
                    'sts' => false,
                    'msg' => $message,
                    'icn' => 'error',
                ];
            } else {
                $res = [
                    'typ' => $req['type'],
                    'sts' => $success,
                    'msg' => $success ? $itrue . ' Penilaian berhasil ' . $msg : $ifalse . ' Penilaian gagal ' . $msg,
                    'icn' => $success ? 'success' : 'error',
                ];
            }

            echo json_encode($res);
        }
    }

    private function should_check($task_id, $source)
    {
        if ($source == 1) {
            $row = $this->question_bank_standart
                ->select('distinct(question_bank_standart_type) as type')
                ->where('question_bank_standart_parent_id', $task_id)
                ->findAll();
        } else {
            $row = $this->question_bank
                ->select(' distinct(question_bank_type) as type')
                ->where('question_bank_parent_id', $task_id)
                ->findAll();
        }

        $type = array_column($row, 'type');

        return in_array(4, $type) ? 'none' : 1;
    }

    public function index_draft()
    {
        $data["title"] = 'Draft';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Draft_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Draft',
        ];

        return view("learningms/assessment/draft", $data);
    }

    public function index_scheduled()
    {
        $data["title"] = 'Terjadwal';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Scheduled_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Terjadwal',
        ];

        return view("learningms/assessment/scheduled", $data);
    }

    public function index_present()
    {
        $data["title"] = 'Saat Ini';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Present_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Saat Ini',
        ];

        return view("learningms/assessment/present", $data);
    }

    public function index_done()
    {
        $data["title"] = 'Selesai';
        $data["page"] = $this->page;
        $data["sidebar"] = 'Done_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        return view("learningms/assessment/done", $data);
    }

    public function list_assessment()
    {
        $req = $this->request->getVar();

        $date_now = datetimenow();
        $school_id = userdata()['school_id'];
        $teacher_id = userdata()['id_profile'];

        $select = '
            assessment_id,
            assessment_title,
            assessment_start,
            assessment_end,
            assessment_grade,
            assessment_subject_id,
            assessment_group,
            assessment_question_bank_src,
            assessment_question_bank_id,
            assessment_duration,
            assessment_is_random,
            assessment_is_autosubmit,
            assessment_is_prevent_cheat,
            assessment_is_show_hint,
            assessment_is_show_explain,
            assessment_is_show_right_answer,
            subject_name,
            question_bank_title,
            question_bank_standart_title,
            school_year_period
        ';

        if ($req['page-ass'] == 1) {
            $get = $this->assessment->data_draft($select, $school_id, $teacher_id);
        } else if ($req['page-ass'] == 2) {
            $get = $this->assessment->data_scheduled($select, $date_now, $school_id, $teacher_id);
        } else if ($req['page-ass'] == 3) {
            $get = $this->assessment->data_present($select, $date_now, $school_id, $teacher_id);
        } else if ($req['page-ass'] == 4) {
            $get = $this->assessment->data_done($select, $date_now, $school_id, $teacher_id);
        }

        $data = [];
        foreach ($get as $k => $v) {
            $groups = '';
            foreach (json_decode($v['assessment_group']) as $key => $val) {
                if ($req['page-ass'] == 3 || $req['page-ass'] == 4) {
                    $groups .= '<a href="" data-group_id="' . $val->id . '" data-assessment_id="' . $v['assessment_id'] . '" data-title="' . $v['assessment_title'] . '" class="badge badge-danger mx-1 view_student fs-6">' . $val->group . '</a>';
                } else {
                    $groups .= '<a href="' . base_url('teacher/groups/view-students/' . $val->id) . '" class="badge badge-danger mx-1 fs-6">' . $val->group . '</a>';
                }
            }

            $task_title = '';
            if ($v['assessment_question_bank_src'] == 1) {
                $task_title = $v['question_bank_standart_title'];
            } else {
                $task_title = $v['question_bank_title'];
            }

            $task = '
                <badge class="hand badge badge-primary fs-6" onclick="view_task_assessment(' . $v['assessment_question_bank_id'] . ', ' . $v['assessment_question_bank_src'] . ')">' . $task_title . '</badge>
            ';

            $hint = '<badge class="badge badge-secondary" data-tooltip="Petunjuk" data-tooltip-location="top"><i class="bi bi-lightbulb-off text-white fs-4"></i></badge>';
            if ($v['assessment_is_show_hint'] > 0) {
                $hint = '<badge class="badge badge-success" data-tooltip="Petunjuk" data-tooltip-location="top"><i class="bi bi-lightbulb text-white fs-4"></i></badge>';
            }

            $duration = '<badge class="badge badge-secondary" data-tooltip="Tanpa Batas Waktu" data-tooltip-location="top"><i class="bi bi-alarm text-white fs-4"></i></badge>';
            if ($v['assessment_duration'] > 0) {
                $duration = '<badge class="badge badge-success" data-tooltip="' . $v['assessment_duration'] . ' Menit" data-tooltip-location="top"><i class="bi bi-alarm text-white fs-4"></i></badge>';
            }

            $suffle = '<badge class="badge badge-secondary" data-tooltip="Acak" data-tooltip-location="top"><i class="bi bi-shuffle text-white fs-4"></i></badge>';
            if ($v['assessment_is_random'] > 0) {
                $suffle = '<badge class="badge badge-success" data-tooltip="Acak" data-tooltip-location="top"><i class="bi bi-shuffle text-white fs-4"></i></badge>';
            }

            $shield = '<badge class="badge badge-secondary" data-tooltip="Anti Curang" data-tooltip-location="top"><i class="bi bi-shield-check text-white fs-4"></i></badge>';
            if ($v['assessment_is_prevent_cheat'] > 0) {
                $shield = '<badge class="badge badge-success" data-tooltip="Anti Curang" data-tooltip-location="top"><i class="bi bi-shield-check text-white fs-4"></i></badge>';
            }

            $send = '<badge class="badge badge-secondary" data-tooltip="Kirim Otomatis" data-tooltip-location="top"><i class="bi bi-cursor text-white fs-4"></i></badge>';
            if ($v['assessment_is_autosubmit'] > 0) {
                $send = '<badge class="badge badge-success" data-tooltip="Kirim Otomatis" data-tooltip-location="top"><i class="bi bi-cursor text-white fs-4"></i></badge>';
            }

            $explain = '<badge class="badge badge-secondary" data-tooltip="Penjelasan" data-tooltip-location="top"><i class="bi bi-journal-check text-white fs-4"></i></badge>';
            if ($v['assessment_is_show_explain'] > 0) {
                $explain = '<badge class="badge badge-success" data-tooltip="Penjelasan" data-tooltip-location="top"><i class="bi bi-journal-check text-white fs-4"></i></badge>';
            }

            $right = '<badge class="badge badge-secondary" data-tooltip="Jawaban Benar" data-tooltip-location="top"><i class="bi bi-eye text-white fs-4"></i></badge>';
            if ($v['assessment_is_show_right_answer'] > 0) {
                $right = '<badge class="badge badge-success" data-tooltip="Jawaban Benar" data-tooltip-location="top"><i class="bi bi-eye text-white fs-4"></i></badge>';
            }

            $lists = '';
            if ($req['page-ass'] == 1) {
                $acts = '
                    <badge class="hand badge badge-dark mt-2" data-tooltip="Ubah Penilaian" data-tooltip-location="right" fs-5 onclick="edit_draft(' . $v['assessment_id'] . ')"><i class="bi bi-pencil-square fs-6 text-white" ></i></badge>
                ';


                $lists = '
                    <div class="row bigrow-tabulator">
                        <div class="col-lg-5 mx-auto">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1 me-2 center">
                                        <span class="text-gray-800 fw-bolder fs-4">' . $v['assessment_title'] . $acts . ' </span>
                                        <div class="bdg-group my-1">
                                        ' . $task . '
                                        </div>
                                        <div class="bdg-group my-1">
                                            ' . $suffle . ' ' . $duration . ' ' . $shield . ' ' . $send . ' ' . $hint . ' ' . $explain . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-800 fw-semibold">' . $v['subject_name'] . '</span>
                                    <div class="bdg-group">
                                    <badge class="badge badge-info mx-1 fs-6">T.P ' . $v['school_year_period'] . '</badge>' . $groups . '&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_start']) . '</span>
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_end']) . '</span>
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
                                        <span class="text-gray-800 fw-bolder fs-4">' . $v['assessment_title'] . '</span>
                                        <div class="bdg-group">
                                        ' . $task . '
                                        </div>
                                        <div class="bdg-group my-1">
                                            ' . $suffle . ' ' . $duration . ' ' . $shield . ' ' . $send . ' ' . $hint . ' ' . $explain . ' ' . $right . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-start align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-800 fw-semibold fs-4">' . $v['subject_name'] . '</span>
                                    <div class="bdg-group">
                                    <badge class="badge badge-info fs-6">T.P ' . $v['school_year_period'] . '</badge>' . $groups . '&nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto">
                            <div class="additional-info">
                                <div class="d-flex align-items-lg-end align-items-sm-center flex-column" style="word-wrap: break-word;">
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_start']) . '</span>
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_end']) . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }

            $data[] = [
                'end_date' => $v['assessment_end'],
                'id' => $v['assessment_id'],
                'title' => $v['assessment_title'],
                'mapel' => $v['subject_name'],
                'period' => datetime_indo($v['assessment_start']) . ' - ' . datetime_indo($v['assessment_end']),
                'group' => $groups,
                'task' => $task,
                'lists' => $lists
            ];
        }

        echo (json_encode($data));
    }

    public function view_assessment_question()
    {
        $req = $this->request->getVar();

        $row = '';
        if ($req['src'] == 1) {
            $row = $this->question_bank_standart
                ->select('question_bank_standart_id as id')
                ->where('question_bank_standart_parent_id', $req['id'])
                ->findAll();
        } else {
            $row = $this->question_bank
                ->select('question_bank_id as id')
                ->where('question_bank_parent_id', $req['id'])
                ->findAll();
        }

        echo json_encode($row);
    }

    public function get_student_assessment()
    {
        $req = $this->request->getVar();

        $rows = $this->assessment_result
            ->select('
                assessment_result_id as result_id,
                assessment_result_semester as result_semester,
                assessment_result_assessment_id as assessment_id,
                assessment_result_group_id as group_id,
                assessment_result_student_id as student_id,
                assessment_result_begin_assignment_datetime as begin_assignment_datetime,
                assessment_result_submit_datetime as submit_datetime,
                assessment_result_value as value,
                assessment_result_is_checked as is_checked,
                assessment_result_submit_message as submit_message,
                student_nisn,
                student_first_name,
                student_last_name,
                student_image
            ')
            ->join('profile_student', 'student_id=assessment_result_student_id', 'left')
            ->where('assessment_result_assessment_id', $req['aid'])
            ->where('assessment_result_school_id', userdata()['school_id'])
            ->where('assessment_result_school_year_id', school_year()['id'])
            ->where('assessment_result_group_id', $req['gid'])
            ->orderBy('student_first_name,student_last_name')
            ->findAll();

        $data = [];
        foreach ($rows as $v) {
            $begin = $v['begin_assignment_datetime'] != null ? '<span class="text-gray-700 fw-bold" style="width: 65px">Mulai </span><badge class="badge badge-success" onclick="lesson_preview(18, 2, 15)"><b>' . datetime_indo($v['begin_assignment_datetime']) . '</b></badge>' : '';
            $submit = $v['submit_datetime'] != null ? '<span class="text-gray-700 fw-bold" style="width: 65px">Selesai </span><badge class="badge badge-success" onclick="lesson_preview(18, 2, 15)"><b>' . datetime_indo($v['submit_datetime']) . '</b></badge>' : '';

            // $value = $v['value'] != null ? '<badge class="badge badge-info my-1">Nilai : <b>' . $v['value'] . ' Poin</b></badge> &nbsp;' : '';
            $txtb = $v['is_checked'] > 0 ? 'Hasil : <b>' . $v['value'] . ' Poin</b>' : 'Periksa';
            $txtbc = $v['is_checked'] > 0 ? 'info' : 'warning';
            $resid = "'" . $v['result_id'] . "'";
            $chktrue = semester() == $v['result_semester'] ? 1 : 0;
            $value = $v['value'] != null ? '<a href="#" onclick="data_result_student(' . $resid . ', '.$chktrue.', '.$v['group_id'].')" class="badge badge-'.$txtbc.' my-1">' . $txtb . '</a> &nbsp;' : '';
            $desc = $v['submit_message'] != null ? 'Ket : ' . $v['submit_message'] : '';

            if ($v['value'] != null) {
                $start = new DateTime($v['begin_assignment_datetime']);
                $end = new DateTime($v['submit_datetime']);
                $interval = $start->diff($end);
            }

            $duration = $v['value'] != null ? '<badge class="badge badge-danger my-1"><b>Dikerjakan selama ' . $interval->format('%h Jam %i Menit') . '</b></badge>' : '';

            $img = '<img src="'.base_url('assets/media/avatars/').'blank.png" alt="P" class="w-100" />';
            if ($v['student_image'] != 'default.png') {
                $img = '<img src="'.getenv()['S3_BUCKET_LINK'].$v['student_image'].'" alt="P" class="w-100" />';
            }
            $lists = '
                <div class="row bigrow-tabulator">
                    <div class="col-lg-4 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-start">
                        
                                <div class="d-flex flex-column">
                                    <div class="cursor-pointer symbol symbol-50px" data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="" data-bs-original-title="User profile">
                                       '.$img.'
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

    public function check_result_assessment()
    {
        $result_id = $this->request->getVar('result_id');
        $result = $this->assessment_result
            ->join('lms_assessment', 'assessment_id=assessment_result_assessment_id', 'left')
            ->join('master_subject', 'subject_id=assessment_subject_id', 'left')
            ->join('profile_student', 'student_id=assessment_result_student_id', 'left')
            ->where('assessment_result_id', $result_id)->first();

        if ($result['assessment_question_bank_src'] == 1) {
            $question_ = $this->question_bank_standart
                ->select('
                    question_bank_standart_id as id,
                    question_bank_standart_question as question,
                    question_bank_standart_option as option,
                    question_bank_standart_answer as answer,
                    question_bank_standart_hint as hint,
                    question_bank_standart_type as type,
                    question_bank_standart_poin as poin
                ')
                ->where('question_bank_standart_parent_id', $result['assessment_question_bank_id'])
                ->findAll();
        } else {
            $question_ = $this->question_bank
                ->select('
                    question_bank_id as id,
                    question_bank_question as question,
                    question_bank_option as option,
                    question_bank_answer as answer,
                    question_bank_hint as hint,
                    question_bank_type as type,
                    question_bank_poin as poin
                ')
                ->where('question_bank_parent_id', $result['assessment_question_bank_id'])
                ->findAll();
        }

        $storage = [];
        $storage['assessment_id'] = $result['assessment_id'];
        $storage['assessment_title'] = $result['assessment_title'];
        $storage['sch_year_id'] = $result['assessment_school_year_id'];
        $storage['subject'] = $result['subject_name'];
        $storage['source_qb'] = $result['assessment_question_bank_src'];
        $storage['qb_parent_id'] = $result['assessment_question_bank_id'];

        $quests = [];
        foreach ($question_ as $k => $v) {
            $quests[$v['id']]['question_id'] = $v['id'];
            $quests[$v['id']]['question'] = $v['question'];

            $opt = $v['option'] != '' && $v['option'] != [] ? json_decode($v['option']) : [];
            // $opt = json_decode($v['option']);
            $opts = [];
            foreach ($opt as $key => $val) {
                $opts['optt_' . $key + 1] = $val;
            }

            $answ = [];
            $ans = $result['assessment_result_answer'] != '' && $result['assessment_result_answer'] != [] ? json_decode($result['assessment_result_answer']) : [];
            // foreach (json_decode($result['assessment_result_answer']) as $idx => $value) {
            foreach ($ans as $idx => $value) {
                if ($value->answer->id == $v['id']) {
                    $answ[] = $v['type'] == 3 ? str_replace('"', '', $value->answer->student_answer) : $value->answer->student_answer;
                    if (isset($value->answer->poin)) {
                        $quests[$v['id']]['note_check'] = $value->answer->note_check;
                        $quests[$v['id']]['res_poin'] = (float)$value->answer->poin;
                    } else {
                        $quests[$v['id']]['res_poin'] = 0;
                        $quests[$v['id']]['note_check'] = '';
                    }
                    $quests[$v['id']]['checked'] = $value->answer->checked;;
                }
            }

            $quests[$v['id']]['option'] = $opts;
            $quests[$v['id']]['type'] = $v['type'];
            $quests[$v['id']]['hint'] = $v['hint'];
            $quests[$v['id']]['student_answer'] = $answ;
            $quests[$v['id']]['right_answer'] = $v['answer'];
            $quests[$v['id']]['poin'] = $v['poin'];
            $quests[$v['id']]['student_poin'] = 0;
        }

        $storage['assessment'] = $quests;

        $data = [
            'key' => 'limecode_' . userdata()['id_profile'] . '_' . $result['assessment_result_student_id'] . '_' . $result['assessment_id'],
            'value' => $storage,
            'student_name' => $result['student_first_name'] . ' ' . $result['student_last_name'],
            'student_id' => $result['assessment_result_student_id'],
            'result_id' => $result_id,
            'assessment_title' => $result['assessment_title'],
            'assessment_id' => $result['assessment_id'],
            'qb_id' => $result['assessment_question_bank_id'],
            'qb_src' => $result['assessment_question_bank_src']
        ];

        echo json_encode($data);
    }

    public function submit_check_assessment()
    {
        $req = $this->request->getVar();
        $result = $this->assessment_result
            ->where('assessment_result_id', $req['res'])->first();

        $arch_ans = [];
        $total_poin = 0;
        $ans = $result['assessment_result_answer'] != '' && $result['assessment_result_answer'] != [] ? json_decode($result['assessment_result_answer']) : [];
        // foreach (json_decode($result['assessment_result_answer']) as $k => $v) {
        foreach ($ans as $k => $v) {
            $arch_ans[$k]['answer']['id'] = $k;
            $arch_ans[$k]['answer']['student_answer'] = $v->answer->student_answer;
            $arch_ans[$k]['answer']['note_check'] = $req['result'][$k]['note_check'];
            $arch_ans[$k]['answer']['poin'] = $req['result'][$k]['res_poin'];
            $arch_ans[$k]['answer']['checked'] = 1;
            $total_poin += $req['result'][$k]['res_poin'];
        }

        if ($req['qb_src'] == 1) {
            $question_ = $this->question_bank_standart
                ->select('
                    question_bank_standart_poin as poin
                ')
                ->where('question_bank_standart_parent_id', $req['qb_id'])
                ->findAll();
        } else {
            $question_ = $this->question_bank
                ->select('
                    question_bank_poin as poin
                ')
                ->where('question_bank_parent_id', $req['qb_id'])
                ->findAll();
        }

        $total_quest_point = 0;
        foreach ($question_ as $k => $v) {
            $total_quest_point += $v['poin'];
        }
        $student_score = $total_poin / $total_quest_point * 100;

        $this->assessment_result->db->transBegin();

        $ecode = 0;
        $message = 'Something went wrong!';
        try {
            $this->result_grades
                ->where('result_grades_school_id', userdata()['school_id'])
                ->where('result_grades_school_year_id', school_year()['id'])
                ->where('result_grades_semester', semester())
                ->where('result_grades_student_id', (int)$req['sid'])
                ->where('result_grades_value_type', 2)
                ->where('result_grades_source_id', (int) $result['assessment_result_assessment_id'])
                ->set('result_grades_original_value', $student_score)
                ->set('result_grades_adjust_value', $student_score)
                ->update();

            $sts_grd = $this->result_grades->error();
            if ($sts_grd['code'] > 0) {
                $message = $sts_grd['message'];
                $ecode = $sts_grd['code'];
                throw new \Exception($message);
            }

            $this->assessment_result
                ->set('assessment_result_answer', json_encode($arch_ans))
                ->set('assessment_result_value', $total_poin)
                ->set('assessment_result_is_checked', 1)
                ->where('assessment_result_id', $req['res'])
                ->update();

            $data = $this->assessment_result->select('DISTINCT(assessment_result_is_checked) total')
                ->where('assessment_result_assessment_id', $result['assessment_result_assessment_id'])
                ->where('assessment_result_school_id', $result['assessment_result_school_id'])
                ->where('assessment_result_school_year_id', $result['assessment_result_school_year_id'])
                ->where('assessment_result_group_id', $result['assessment_result_group_id'])
                ->findAll();

            $sts = array_column($data, 'total');
            if (!in_array(0, $sts)) {
                $assessment = $this->assessment->select('assessment_group')
                    ->where('assessment_id', $result['assessment_result_assessment_id'])
                    ->first();

                $groups  = json_decode($assessment['assessment_group']);
                foreach ($groups as $k => $v) {
                    if ($v->id == $result['assessment_result_group_id']) {
                        $groups[$k]->checked_all = 1;
                    }
                }

                $this->assessment
                    ->set('assessment_group', json_encode($groups))
                    ->set('assessment_updated_by', session()->get('c_id'))
                    ->where('assessment_id', $result['assessment_result_assessment_id'])
                    ->update();

                $sts_chk = $this->assessment->error();
                if ($sts_chk['code'] > 0) {
                    $message = $sts_chk['message'];
                    $ecode = $sts_chk['code'];
                    throw new \Exception($message);
                }
                
            }

            if ($ecode > 0) {
                throw new \Exception($message);
            }

            $this->assessment_result->db->transCommit();
            $this->activity->store_log('Penilaian', 'submit', 'periksa penilaian "' . $req['title'] . '" siswa "' . $req['student'] . '"');


            $s = $this->assessment->select('subject_name')
                ->join('master_subject', 'subject_id = assessment_subject_id')
                ->where('assessment_id', $result['assessment_result_assessment_id'])
                ->first();
            $dt = datetime_indo(date('Y-m-d H:i:s'));

            $this->notification->store_notification_check(
                3,
                $result['assessment_result_assessment_id'],
                "Hasil Penilaian",
                "Penilaian {$req['title']} mata pelajaran {$s['subject_name']} telah selesai diperiksa pada {$dt}.",
                $result['assessment_result_student_id']
            );

            $return = [
                'sts' => true,
                'msg' => 'Pemeriksaan berhasil disimpan!',
                'icn' => 'success'
            ];

            echo json_encode($return);
        } catch (\Throwable $th) {
            logging('error', 'transaction submit check assessment result failed : ' . $th->getMessage());
            $this->assessment_result->db->transRollback();
            $return = [
                'sts' => false,
                'msg' => $message,
                'icn' => 'error'
            ];

            echo json_encode($return);
        }
    }

    // BEGIN STUDENT FUNCTION

    public function s_index_present()
    {
        $data["title"] = 'Aktif';
        $data["page"] = 'Student Assessment';
        $data["sidebar"] = 'Present_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Aktif',
        ];

        // if ($notif_id != null) {
        //     $this->notification_read->read_notification($notif_id);
        // }

        return view("learningms/assessment/present_s", $data);
    }

    public function s_index_missed()
    {
        $data["title"] = 'Terlewat';
        $data["page"] = 'Student Assessment';
        $data["sidebar"] = 'Missed_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Terlewat',
        ];

        return view("learningms/assessment/missed", $data);
    }

    public function s_index_done()
    {
        $data["title"] = 'Selesai';
        $data["page"] = 'Student Assessment';
        $data["sidebar"] = 'Done_Assessment';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Selesai',
        ];

        // if ($notif_id != null) {
        //     $this->notification_read->read_notification($notif_id);
        // }

        return view("learningms/assessment/done_s", $data);
    }

    public function s_list_assessment()
    {
        $req = $this->request->getVar();
        $list = $this->assessment->get_list_student($req['page-ass']);

        $my_assign = $this->assessment_result
            ->select('assessment_result_assessment_id ass_id')
            ->where('assessment_result_student_id', userdata()['id_profile'])
            ->findAll();

        $my_assign = array_column($my_assign, 'ass_id');
        $my_list = array_column($list, 'assessment_id');

        $merge_idx = array_merge($my_assign, $my_list);
        $list_idx = array_unique(array_diff_assoc($merge_idx, array_unique($merge_idx)));

        $data = [];
        foreach ($list as $k => $v) {
            if ($req['page-ass'] == 1 || $req['page-ass'] == 2) {

                if (in_array($v['assessment_id'], $list_idx)) {
                    $deg = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : '';
                    $name = $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg;
                    $duration = $v['assessment_duration'] > 0 ? $v['assessment_duration'] . " Menit" : '-';
                    $button = '';
                    if ($req['page-ass'] == 1) {
                        $button = '<a href="#" class="btn btn-primary pl-10" onclick="alert_begin_assessment(' . $v['assessment_id'] . ')">Kerjakan</a>';
                    }

                    $lists = '
                    <div class="row bigrow-tabulator">
                        <div class="col-lg-5 mx-auto">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    ' . $button . '
                                    <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                        <h5 class="">' . $v['assessment_title'] . '</h5>
                                        <badge class="badge badge-info"><i class="bi-alarm text-white"></i> ' . $duration . '</badge>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mx-auto">
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
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_start']) . '</span>
                                    <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_end']) . '</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    $data[] = [
                        'id' => $v['assessment_id'],
                        'lists' => $lists
                    ];
                }
            } else {
                $deg = $v['teacher_degree'] != '' ? ', ' . $v['teacher_degree'] : '';
                $name = $v['teacher_first_name'] . ' ' . $v['teacher_last_name'] . $deg;
                $duration = $v['assessment_duration'] > 0 ? $v['assessment_duration'] . " Menit" : '-';


                $lists = '
                    <div class="row bigrow-tabulator">
                    <div class="col-lg-5 mx-auto">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                            <button data-id="' . $v['assessment_id'] . '" data-student="' . userdata()['id_profile'] . '" data-school="' . userdata()['school_id'] . '" class="view_done_ass btn btn-primary pl-10">Lihat Hasil</button>
                                <div class="flex-grow-1 mx-5" style="word-wrap: break-word;">
                                    <h5 class="">' . $v['assessment_title'] . '</h5>
                                    <badge class="badge badge-info"><i class="bi-alarm text-white"></i> ' . $duration . '</badge>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mx-auto">
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
                                <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_start']) . '</span>
                                <span class="text-gray-700 fw-semibold">' . datetime_indo($v['assessment_end']) . '</span>
                            </div>
                        </div>
                    </div>
                </div>
                ';

                $data[] = [
                    'id' => $v['assessment_id'],
                    'lists' => $lists
                ];
            }
        }

        echo (json_encode($data));
    }

    public function s_get_assessment()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 1) {
            $data = $this->assessment
                ->select('
                    assessment_id,
                    assessment_school_year_id,
                    assessment_title,
                    assessment_start,
                    assessment_end,
                    assessment_duration,
                    assessment_instruction,
                    assessment_is_autosubmit,
                    assessment_is_random,
                    assessment_is_prevent_cheat,
                    assessment_is_show_hint,
                    assessment_question_bank_id,
                    assessment_question_bank_src,
                    subject_name,
                    teacher_first_name,
                    teacher_last_name,
                    teacher_degree,
                ')
                ->join('master_subject', 'subject_id=assessment_subject_id', 'left')
                ->join('profile_teacher', 'teacher_id=assessment_teacher_id', 'left')
                ->where('assessment_id', $req['id'])->first();

            $data['end'] = datetime_indo($data['assessment_end']);
            $data['end_time'] = $data['assessment_end'];
            $data['period'] = datetime_indo($data['assessment_start']) . ' s/d ' . datetime_indo($data['assessment_end']);
            $data['instruction'] = $data['assessment_instruction'] != null && $data['assessment_instruction'] != '<p><br></p>' ? $data['assessment_instruction'] : '-';

            $school = userdata()['school_id'];
            $group = student_group()['group_id'];

            $notif_whr = [
                'notification_lms_school_id' => $school,
                'notification_lms_source_type' => 1,
                'notification_lms_source_id' => $data['assessment_id'],
                'notification_lms_group_id' => $group
            ];

            $notif = $this->notification->select('notification_lms_id id')->where($notif_whr)->first();
            $this->notification_read->read_notification($notif['id']);

        } else if ($req['type'] == 2) {

            $student_id = userdata()['id_profile'];
            $assessment_id = $req['src'][8];
            $assessment_title = $req['src'][0];
            $subject = $req['src'][1];
            $end_period = $req['src'][2];
            $timer = $req['src'][3];
            $autosubmit = $req['src'][4];
            $random = $req['src'][5];
            $no_cheat = $req['src'][6];
            $sch_year_id = $req['src'][9];

            $this->assessment_result
                ->where('assessment_result_student_id', $student_id)
                ->where('assessment_result_assessment_id', $assessment_id)
                ->where('assessment_result_school_id', userdata()['school_id'])
                ->where('assessment_result_school_year_id', $sch_year_id)
                ->where('assessment_result_semester', semester())
                ->set('assessment_result_begin_assignment_datetime', datetimenow())
                ->update();

            $question = ['kosong'];
            if ($req['src'][7] == 1) {
                $question_ = $this->question_bank_standart
                    ->select('
                        question_bank_standart_id as id,
                        question_bank_standart_question as question,
                        question_bank_standart_option as option,
                        question_bank_standart_hint as hint,
                        question_bank_standart_type as type
                    ')
                    ->where('question_bank_standart_parent_id', $req['id'])
                    ->findAll();
            } else {
                $question_ = $this->question_bank
                    ->select('
                        question_bank_id as id,
                        question_bank_question as question,
                        question_bank_option as option,
                        question_bank_hint as hint,
                        question_bank_type as type
                    ')
                    ->where('question_bank_parent_id', $req['id'])
                    ->findAll();
            }

            if ($random) {
                shuffle($question_);
            }

            $storage = [];
            $storage['assessment_id'] = $assessment_id;
            $storage['assessment_title'] = $assessment_title;
            $storage['sch_year_id'] = $sch_year_id;
            $storage['subject'] = $subject;
            $storage['begin_assign'] = datetimenow();
            $storage['end_date'] = $end_period;
            $storage['timer'] = $timer;
            $storage['autosubmit'] = $autosubmit;
            $storage['no_cheat'] = $no_cheat;
            $storage['fault'] = 0;
            $storage['show_hint'] = $req['src'][10];
            $storage['source_qb'] = $req['src'][7];
            $storage['qb_parent_id'] = $req['id'];

            $quests = [];
            foreach ($question_ as $k => $v) {
                $quests[$v['id']]['question_id'] = $v['id'];
                $quests[$v['id']]['question'] = $v['question'];
                // $opt = json_decode($v['option']);
                $opt = $v['option'] != '' && $v['option'] != [] ? json_decode($v['option']) : [];
                if ($random) {
                    shuffle($opt);
                }

                $opts = [];
                foreach ($opt as $key => $val) {
                    $opts['opt_' . $key + 1] = $val;
                }

                $quests[$v['id']]['option'] = $opts;
                $quests[$v['id']]['type'] = $v['type'];
                $quests[$v['id']]['hint'] = $v['hint'];
                $quests[$v['id']]['student_answer'] = '[]';
            }

            $storage['assessment'] = $quests;
            $data = [
                'key' => 'redcode_' . $student_id,
                'value' => $storage
            ];

            $this->activity->store_log('Penilaian', 'doing', 'mulai mengerjakan penilaian "' . $assessment_title . '"');
        }

        echo json_encode($data);
    }

    public function s_submit_assessment()
    {
        $row = $this->request->getVar('send');
        
        if ($row['source_qb'] == 1) {
            $question_ = $this->question_bank_standart
                ->select('
                    question_bank_standart_id as id,
                    question_bank_standart_answer as answer,
                    question_bank_standart_poin as poin,
                    question_bank_standart_type as type
                ')
                ->where('question_bank_standart_parent_id', $row['qb_parent_id'])
                ->findAll();
        } else {
            $question_ = $this->question_bank
                ->select('
                    question_bank_id as id,
                    question_bank_answer as answer,
                    question_bank_poin as poin,
                    question_bank_type as type
                ')
                ->where('question_bank_parent_id', $row['qb_parent_id'])
                ->findAll();
        }

        $arr_right_answer = [];
        foreach ($question_ as $k => $v) {
            $ans = $v['answer'] != '' && $v['answer'] != [] ? json_decode($v['answer']) : [];
            // $ans = json_decode($v['answer']);
            sort($ans);
            $arr_right_answer[$v['id']]['answer'] = $ans;
            $arr_right_answer[$v['id']]['poin'] = $v['poin'];
            $arr_right_answer[$v['id']]['type'] = $v['type'];
        }

        $arr_student_answer = [];
        foreach ($row['answer'] as $k => $v) {
            if ($v['answer'] != '' || $v['answer'] != null) {
                $ans = $v['answer'];
                if ($v['question_type'] < 4) {
                    if (count($ans) > 0) {
                        sort($ans);
                    }
                }
            }
            $arr_student_answer[$v['question_id']] = $ans;
        }

        $arch_ans = [];
        $total_poin = 0;
        foreach ($arr_right_answer as $k => $v) {
            if ($v['type'] < 4) {
                if (count($v['answer']) < 2) {
                    if ($v['answer'][0] == $arr_student_answer[$k][0]) {
                        $total_poin = $total_poin + $v['poin'];
                        $arch_ans[$k]['answer']['poin'] = $v['poin'];
                    } else {
                        $arch_ans[$k]['answer']['poin'] = 0;
                    }
                } else {
                    $mcx = [];
                    for ($i = 0; $i < count($arr_student_answer[$k]); $i++) {
                        if (in_array($arr_student_answer[$k][$i], $v['answer']) && count($arr_student_answer[$k]) == count($v['answer'])) {
                            $mcx[] = true;
                        } else {
                            $mcx[] = false;
                        }
                    }

                    if (!in_array(false, $mcx)) {
                        $total_poin = $total_poin + $v['poin'];
                        $arch_ans[$k]['answer']['poin'] = $v['poin'];
                    } else {
                        $arch_ans[$k]['answer']['poin'] = 0;
                    }
                }

                $arch_ans[$k]['answer']['id'] = $k;
                $arch_ans[$k]['answer']['student_answer'] = $arr_student_answer[$k];
                $arch_ans[$k]['answer']['checked'] = 1;
            } else {
                $arch_ans[$k]['answer']['id'] = $k;
                $arch_ans[$k]['answer']['student_answer'] = $arr_student_answer[$k];
                // $arch_ans[$k]['answer']['poin'] = 0;
                $arch_ans[$k]['answer']['checked'] = 0;
            }
            $arch_ans[$k]['answer']['note_check'] = '';
        }

        $this->assessment_result->db->transBegin();
        try {
            $calculated = $total_poin / count($row['answer']) * 100;
            $this->assessment_result
                ->where('assessment_result_student_id',  userdata()['id_profile'])
                ->where('assessment_result_assessment_id', $row['assessment_id'])
                ->where('assessment_result_school_id', userdata()['school_id'])
                ->where('assessment_result_school_year_id', $row['sch_year_id'])
                ->where('assessment_result_semester', semester())
                ->set('assessment_result_begin_assignment_datetime', $row['begin_assign'])
                ->set('assessment_result_submit_datetime', datetimenow())
                ->set('assessment_result_end_datetime', $row['end_date'])
                ->set('assessment_result_answer', json_encode($arch_ans))
                ->set('assessment_result_value', $total_poin)
                ->set('assessment_result_fault', $row['fault'])
                ->set('assessment_result_submit_message', $row['msg_submit'])
                ->update();

            $sts = $this->assessment_result->error();

            $msgsmbt = '<h2>Sukses</h2><br><p>Penilaian <b>' . $row['assessment_title'] . '</b> mata pelajaran <b>' . $row['subject'] . '</b> berhasil dikirimkan</p>';
            $msglog = 'penilaian "' . $row['assessment_title'] . '" mata pelajaran "' . $row['subject'] . '" dikirimkan';
            if ($row['submit_type'] != 1) {
                $msglog = 'penilaian "' . $row['assessment_title'] . '" mata pelajaran "' . $row['subject'] . '" terkirim otomatis karena "' . $row['msg_submit'] . '"';
                $msgsmbt = '<h2>Penilaian Terkirim Otomatis</h2><br><p>Penilaian <b>' . $row['assessment_title'] . '</b> mata pelajaran <b>' . $row['subject'] . '</b> terkirim otomatis karena <b>' . $row['msg_submit'] . '</b></p>';
            }

            if ($sts['code'] > 0) {
                $res = [
                    'sts' => false,
                    'msg' => '<h2>Oops..</h2><br><p>Penilaian <b>' . $row['assessment_title'] . '</b> mata pelajaran <b>' . $row['subject'] . '</b> gagal dikirimkan</p>',
                    'icn' => 'error',
                ];
            } else {
                $this->activity->store_log('Penilaian', 'submit', $msglog);
                $res = [
                    'sts' => true,
                    'msg' => $msgsmbt,
                    'icn' => 'success',
                ];
            }

            $this->result_grades
                ->where('result_grades_school_id', userdata()['school_id'])
                ->where('result_grades_school_year_id', school_year()['id'])
                ->where('result_grades_semester', semester())
                ->where('result_grades_student_id', userdata()['id_profile'])
                ->where('result_grades_value_type', 2)
                ->where('result_grades_source_id', $row['assessment_id'])
                ->set('result_grades_original_value', $calculated)
                ->set('result_grades_adjust_value', $calculated)
                ->update();

            $stsrg = $this->result_grades->error();
            if ($stsrg['code'] > 0) {
                throw new \Exception($stsrg['message']);
            }

            $this->assessment_result->db->transCommit();
        } catch (\Throwable $th) {
            logging('error', 'student submit assessment failed : ' . $th->getMessage());
            $this->assessment_result->db->transRollback();
        }
        
        echo json_encode($res);
    }

    public function s_get_assessment_done()
    {
        $req = $this->request->getVar();

        $school = userdata()['school_id'];
        $student = userdata()['id_profile'];

        $notif_whr = [
            'notification_lms_school_id' => $school,
            'notification_lms_source_type' => 3,
            'notification_lms_source_id' => $req['assessment'],
            'notification_lms_student_id' => $student
        ];

        $notif = $this->notification->select('notification_lms_id id')->where($notif_whr)->first();
        if ($notif) {
            $this->notification_read->read_notification($notif['id']);
        }

        // $result_id = $this->request->getVar('result_id');
        $ass_row = $this->assessment->where('assessment_id', $req['assessment'])->first();
        $result = $this->assessment_result
            ->join('lms_assessment', 'assessment_id=assessment_result_assessment_id', 'left')
            ->join('master_subject', 'subject_id=assessment_subject_id', 'left')
            ->join('profile_student', 'student_id=assessment_result_student_id', 'left')
            ->where('assessment_result_assessment_id', $req['assessment'])
            ->where('assessment_result_school_id', $req['schoolid'])
            ->where('assessment_result_student_id', $req['studentid'])
            ->first();

        if ($result['assessment_question_bank_src'] == 1) {
            $question_ = $this->question_bank_standart
                ->select('
                    question_bank_standart_id as id,
                    question_bank_standart_question as question,
                    question_bank_standart_option as option,
                    question_bank_standart_answer as answer,
                    question_bank_standart_hint as hint,
                    question_bank_standart_explain as explain,
                    question_bank_standart_type as type,
                    question_bank_standart_poin as poin
                ')
                ->where('question_bank_standart_parent_id', $result['assessment_question_bank_id'])
                ->findAll();
        } else {
            $question_ = $this->question_bank
                ->select('
                    question_bank_id as id,
                    question_bank_question as question,
                    question_bank_option as option,
                    question_bank_answer as answer,
                    question_bank_hint as hint,
                    question_bank_explain as explain,
                    question_bank_type as type,
                    question_bank_poin as poin
                ')
                ->where('question_bank_parent_id', $result['assessment_question_bank_id'])
                ->findAll();
        }

        $storage = [];
        $storage['assessment_id'] = $result['assessment_id'];
        $storage['assessment_title'] = $result['assessment_title'];
        $storage['sch_year_id'] = $result['assessment_school_year_id'];
        $storage['subject'] = $result['subject_name'];
        $storage['source_qb'] = $result['assessment_question_bank_src'];
        $storage['qb_parent_id'] = $result['assessment_question_bank_id'];
        $storage['show_hint'] = $ass_row['assessment_is_show_hint'];
        $storage['show_explain'] = $ass_row['assessment_is_show_explain'];
        $storage['show_right_answer'] = $ass_row['assessment_is_show_right_answer'];

        $quests = [];
        foreach ($question_ as $k => $v) {
            $quests[$v['id']]['question_id'] = $v['id'];
            $quests[$v['id']]['question'] = $v['question'];
            // $opt = json_decode($v['option']);
            $opt = $v['option'] != '' && $v['option'] != [] ? json_decode($v['option']) : [];
            $opts = [];
            foreach ($opt as $key => $val) {
                $opts['optt_' . $key + 1] = $val;
            }

            $answ = [];
            $ans = $result['assessment_result_answer'] != '' && $result['assessment_result_answer'] != [] ? json_decode($result['assessment_result_answer']) : [];
            // foreach (json_decode($result['assessment_result_answer']) as $idx => $value) {
            foreach ($ans as $idx => $value) {
                if ($value->answer->id == $v['id']) {
                    $answ[] = $v['type'] == 3 ? str_replace('"', '', $value->answer->student_answer) : $value->answer->student_answer;
                    if (isset($value->answer->poin)) {
                        $quests[$v['id']]['note_check'] = $value->answer->note_check;
                        $quests[$v['id']]['res_poin'] = (float)$value->answer->poin;
                    } else {
                        $quests[$v['id']]['res_poin'] = 0;
                        $quests[$v['id']]['note_check'] = '';
                    }
                    $quests[$v['id']]['checked'] = $value->answer->checked;;
                }
            }

            $quests[$v['id']]['option'] = $opts;
            $quests[$v['id']]['type'] = $v['type'];
            $quests[$v['id']]['hint'] = $v['hint'];
            $quests[$v['id']]['explain'] = $v['explain'];
            $quests[$v['id']]['student_answer'] = $answ;
            $quests[$v['id']]['right_answer'] = $v['answer'];
            $quests[$v['id']]['poin'] = $v['poin'];
            $quests[$v['id']]['student_poin'] = 0;
        }

        $storage['assessment'] = $quests;

        $data = [
            'key' => 'yellowcode_' . $result['assessment_result_student_id'] . '_' . $result['assessment_id'],
            'value' => $storage,
            'student_name' => $result['student_first_name'] . ' ' . $result['student_last_name'],
            'student_id' => $result['assessment_result_student_id'],
            'assessment_title' => $result['assessment_title'],
            'assessment_id' => $result['assessment_id']
        ];

        echo json_encode($data);
    }
}
