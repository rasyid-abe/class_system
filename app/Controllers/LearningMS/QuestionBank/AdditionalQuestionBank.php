<?php

namespace App\Controllers\LearningMS\QuestionBank;

use App\Controllers\BaseController;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\Management\TeachingSubjectsModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;
use App\Models\Activities\ActivityModel;
use PDO;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;

class AdditionalQuestionBank extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $teacher_subject;
    protected $question_bank;
    protected $teacher;
    protected $subject;
    protected $activity;

    public function __construct()
    {
        $this->title = "Bank Soal";
        $this->page = "Question";
        $this->sidebar = "QB_Additional";
        $this->question_bank = new QuestionBankModel();
        $this->teacher_subject = new TeachingSubjectsModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->activity = new ActivityModel();
    }

    public function index()
    {
        $data["title"] = 'Bank Soal Saya';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Bank Soal Saya',
        ];

        $mysubs = $this->teacher_subject
            ->select('
                student_group_name,
                student_group_grade,
                subject_name,
                subject_id,
                timetable_group_id
            ')
            ->join('manage_timetable', 'timetable_teaching_subjects_id = teaching_subjects_id')
            ->join('master_student_group', 'student_group_id = teaching_subjects_student_group_id', 'left')
            ->join('master_subject', 'subject_id = teaching_subjects_subject_id', 'left')
            ->join('master_teaching_schedule', 'teaching_schedule_id = timetable_teaching_schedule_id', 'left')
            ->where([
                'teaching_subjects_school_id' => userdata()['school_id'],
                'teaching_subjects_school_year_id' => school_year()['id'],
                'teaching_subjects_teacher_id' => userdata()['id_profile'],
                'teaching_subjects_status < 9',
            ])
            ->groupBy('student_group_id')
            ->findAll();
        // $mysubs = $this->teacher_subject
        //     ->select('student_group_id, student_group_name, student_group_grade, subject_id, subject_name')
        //     ->join('manage_timetable', 'timetable_teaching_subjects_id = teaching_subjects_id', 'left')
        //     ->join('master_student_group', 'student_group_id = timetable_group_id', 'left')
        //     ->join('master_subject', 'subject_id = teaching_subjects_subject_id', 'left')
        //     ->where('teaching_subjects_school_id', userdata()['school_id'])
        //     ->where('teaching_subjects_teacher_id', userdata()['id_profile'])
        //     ->where('teaching_subjects_status < 9')
        //     ->orderBy('student_group_grade')
        //     ->findAll();

        // echo '<pre>';
        // print_r($mysubs);
        // echo '</pre>';
        // die;

        $subs = [];
        foreach ($mysubs as $k => $v) {
            $subs[$v['subject_id']]['subj_id'] = $v['subject_id'];
            $subs[$v['subject_id']]['subj_name'] = $v['subject_name'];
            $subs[$v['subject_id']]['grade'][$v['student_group_grade']] = $v['student_group_grade'];
        }

        $data['mysubs'] = $subs;

        return view("learningms/question_bank_additional/index", $data);
    }

    public function first_page()
    {
        $req = $this->request->getVar();

        $total_title = $this->question_bank
            ->select('count(*) as total')
            ->where('question_bank_status < 9')
            ->where('question_bank_school_id', userdata()['school_id'])
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_parent_id', 0)
            // ->groupBy('question_bank_title, question_bank_grade')
            ->first();
        $total_quest = $this->question_bank
            ->select('count(*) as total')
            ->where('question_bank_status < 9')
            ->where('question_bank_school_id', userdata()['school_id'])
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_parent_id > 0')
            // ->groupBy('question_bank_title')
            ->first();

        $res = [
            't_title' => $total_title['total'],
            't_quest' => $total_quest['total'],
        ];

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
            '/teacher/question-bank/additional' => 'Bank Soal Saya',
            '##' => $subs['subject_name'] . ' - Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title, question_bank_shared_type')
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

    public function grab_list_quest_title()
    {
        $grade = $this->request->getVar('gid');
        $subject = $this->request->getVar('sid');

        $data = [];
        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title, question_bank_shared_type')
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


        echo json_encode($data);
    }

    public function share_task()
    {
        $req = $this->request->getVar();
        $title = $this->question_bank->select('question_bank_title')->where('question_bank_id', $req['idd'])->first();
        if ($req['val'] == 0) {
            $this->question_bank
                ->where('question_bank_id', $req['idd'])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->set('question_bank_shared_type', $req['val'])
                ->set('question_bank_shared_to', '')
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'collapse' => 0,
                    'show_quest' => 0,
                    'id' => [$req['idd']]
                ];
            } else {
                $this->activity->store_log('Bank Soal Standar', 'share', 'membatalkan pembagian bank soal "'.$title['question_bank_title'].'"');

                $res = [
                    'collapse' => 0,
                    'show_quest' => 0,
                    'id' => [$req['idd']]
                ];
            }

            echo json_encode($res);
        } else {
            $shared_to = '';
            if ($req['val'] == 4) {
                $shared_to = isset($req['thc']) != '' ? json_encode($req['thc']) : '';
            }

            $this->question_bank
                ->where('question_bank_id', $req['idd'])
                ->set('question_bank_shared_type', $req['val'])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->set('question_bank_shared_to', $shared_to)
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'collapse' => 0,
                    'show_quest' => 0,
                    'id' => [$req['idd']]
                ];
            } else {
                $this->activity->store_log('Bank Soal Standar', 'share', 'membagikan bank soal "'.$title['question_bank_title'].'"');

                $res = [
                    'collapse' => 0,
                    'show_quest' => 0,
                    'id' => [$req['idd']]
                ];
            }

            echo json_encode($res);
        }
    }

    public function get_question()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 'shr') {
            $res = $this->question_bank
                ->select('
                    question_bank_id,
                    question_bank_shared_type,
                    question_bank_shared_to
                ')
                ->where('question_bank_id', $req['id'])
                ->first();
        } else {
            $d = $this->question_bank
                ->where('question_bank_id', $req['id'])
                ->where('question_bank_status < 9')
                ->first();
            $title = $this->question_bank->select('question_bank_title')->where('question_bank_id', $d['question_bank_parent_id'])->first();

            $opt = json_decode($d['question_bank_option']);
            $ans = json_decode($d['question_bank_answer']);

            $idx_ans = [];
            foreach ($ans as $k => $v) {
                $idx_ans[] = array_search($v, $opt);
            }

            $res = [
                'id' => $d['question_bank_id'],
                'parent' => $d['question_bank_parent_id'],
                'subj' => $d['question_bank_subject_id'],
                'grad' => $d['question_bank_grade'],
                'title' => $title['question_bank_title'],
                'poin' => $d['question_bank_poin'],
                'type' => $d['question_bank_type'],
                'keys' => $idx_ans,
                'question' => $d['question_bank_question'],
                'option' => $opt,
                'explain' => $d['question_bank_explain'],
                'hint' => $d['question_bank_hint'],
                'list_quest' => get_list('question_type'),
            ];
        }

        echo json_encode($res);
    }

    public function update_content()
    {
        $req = $this->request->getVar();
        $typ_q = [1 => 'Pilihan Ganda', 'Pilihan Ganda Kompleks', 'Benar Salah', 'Uraian'];

        if ($req['type'] == 1) {
            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $req['val'][1],
                'question_bank_grade' => $req['val'][2],
                'question_bank_title' => htmlspecialchars($req['val'][0]),
                'question_bank_status' => 1,
                'question_bank_created_by' => userdata()['user_id']
            ];

            $this->question_bank->insert($ins);
            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Judul Bank Soal gagal ditambahkan.',
                    'icon' => 'error',
                    'collapse' => 0,
                    'id' => [0]
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'insert', 'menambahkan judul bank soal "'. htmlspecialchars($req['val'][0]) .'"');

                $res = [
                    'head' => '',
                    'msg' => 'Judul Bank Soal berhasil ditambahkan.',
                    'icon' => 'success',
                    'collapse' => 0,
                    'id' => [0]
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == 2) {
            $this->question_bank
                ->set('question_bank_title', htmlspecialchars($req['val'][0]))
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Judul Bank Soal gagal diubah.',
                    'icon' => 'error',
                    'collapse' => 0,
                    'id' => [0]
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'update', 'mengubah judul bank soal "'. htmlspecialchars($req['val'][0]) .'"');

                $res = [
                    'head' => '',
                    'msg' => 'Judul Bank Soal berhasil diubah.',
                    'icon' => 'success',
                    'collapse' => 0,
                    'id' => [0]
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -1) {
            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $req['val'][0],
                'question_bank_grade' => $req['val'][1],
                'question_bank_type' => $req['val'][2],
                'question_bank_question' => $req['val'][3],
                'question_bank_option' => $req['val'][4],
                'question_bank_answer' => $req['val'][5],
                'question_bank_poin' => $req['val'][6],
                'question_bank_hint' => $req['val'][7],
                'question_bank_explain' => $req['val'][8],
                'question_bank_parent_id' => $req['id'],
                'question_bank_status' => 1,
                'question_bank_created_by' => userdata()["user_id"]
            ];

            $this->question_bank->insert($ins);
            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Soal gagal ditambahkan.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['id']],
                    'chid' => $this->question_bank->getInsertID()
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'insert', 'menambahkan soal "'.$typ_q[$req['val'][2]].'" pada "'. htmlspecialchars($req['val'][9]) .'"');

                $res = [
                    'head' => '',
                    'msg' => 'Soal berhasil ditambahkan.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['id']],
                    'chid' => $this->question_bank->getInsertID()
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -11) {
            $this->question_bank
                ->set('question_bank_question', $req['val'][3])
                ->set('question_bank_option', $req['val'][4])
                ->set('question_bank_answer', $req['val'][5])
                ->set('question_bank_poin', $req['val'][6])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Soal gagal diubah.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][7]],
                    'chid' => $req['id']
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'update', 'mengubah soal "'.$typ_q[$req['val'][2]].'" pada "'. htmlspecialchars($req['val'][8]) .'"');

                $res = [
                    'head' => '',
                    'msg' => 'Soal berhasil diubah.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][7]],
                    'chid' => $req['id']
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -12) {
            $this->question_bank
                ->set('question_bank_hint', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Petunjuk Soal gagal diperbarui.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1]],
                    'chid' => $req['id']
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'update', 'memperbarui petunjuk pengerjaan soal');

                $res = [
                    'head' => '',
                    'msg' => 'Petunjuk Soal berhasil diperbarui.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1]],
                    'chid' => $req['id']
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -13) {
            $this->question_bank
                ->set('question_bank_explain', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Penjelasan Soal gagal diperbarui.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1]],
                    'chid' => $req['id']
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'update', 'memperbarui penjelasan pengerjaan soal');

                $res = [
                    'head' => '',
                    'msg' => 'Penjelasan Soal berhasil diperbarui.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1]],
                    'chid' => $req['id']
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -14) {
            $this->question_bank
                ->set('question_bank_parent_id', $req['val'][0])
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Pindah soal gagal.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1], $req['val'][0]],
                    'chid' => $req['id'],
                    'coll_act' => 0
                ];
            } else {
                $parent = $this->question_bank->select('question_bank_title, question_bank_id')->whereIn('question_bank_id', [$req['val'][1], $req['val'][0]])->findAll();
                $p = [];
                foreach ($parent as $v) {
                    $p[$v['question_bank_id']] = $v['question_bank_title'];
                }
                $this->activity->store_log('Bank Soal Saya', 'move', 'memindahkan soal dari "'.$p[$req['val'][1]].'" ke "'.$p[$req['val'][0]].'"');
                $res = [
                    'head' => '',
                    'msg' => 'Pindah soal berhasil.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1], $req['val'][0]],
                    'chid' => $req['id'],
                    'coll_act' => 0
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == -15) {
            $d = $this->question_bank->where('question_bank_id', $req['id'])->first();

            $ins = [
                'question_bank_school_id' => userdata()['school_id'],
                'question_bank_teacher_id' => userdata()['id_profile'],
                'question_bank_subject_id' => $d['question_bank_subject_id'],
                'question_bank_grade' => $d['question_bank_grade'],
                'question_bank_type' => $d['question_bank_type'],
                'question_bank_question' => $d['question_bank_question'],
                'question_bank_option' => $d['question_bank_option'],
                'question_bank_answer' => $d['question_bank_answer'],
                'question_bank_poin' => $d['question_bank_poin'],
                'question_bank_hint' => $d['question_bank_hint'],
                'question_bank_explain' => $d['question_bank_explain'],
                'question_bank_parent_id' => $req['val'][0],
                'question_bank_status' => 1,
                'question_bank_created_by' => userdata()["user_id"]
            ];

            $this->question_bank->insert($ins);
            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Salin soal gagal.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1], $req['val'][0]],
                    'chid' => $this->question_bank->getInsertID(),
                    'coll_act' => 0,
                    'src' => $req['val'][2]
                ];
            } else {
                if ($req['val'][2] == 2) {
                    $parent = $this->question_bank->select('question_bank_title, question_bank_id')->whereIn('question_bank_id', [$req['val'][1], $req['val'][0]])->findAll();
                    $p = [];
                    foreach ($parent as $v) {
                        $p[$v['question_bank_id']] = $v['question_bank_title'];
                    }
                    $this->activity->store_log('Bank Soal Saya', 'copy', 'salin soal dari "'.$p[$req['val'][1]].'" ke "'.$p[$req['val'][0]].'"');
                } else {
                    if ($req['val'][2] != null) {
                        $this->activity->store_log('Bank Soal Publik', 'copy', 'salin soal dari "Bank Soal Publik" ke "Bank Soal Saya"');
                    } else  {
                        $this->activity->store_log('Bank Soal Saya', 'copy', 'salin soal dari "Bank Soal Publik" ke "Bank Soal Saya"');
                    }
                }

                $res = [
                    'head' => '',
                    'msg' => 'Salin soal berhasil.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['val'][1], $req['val'][0]],
                    'chid' => $this->question_bank->getInsertID(),
                    'coll_act' => 0,
                    'src' => $req['val'][2]

                ];
            }

            echo json_encode($res);
        }
    }

    public function remove_content()
    {
        $req = $this->request->getVar();
  
        $sts = [];
        if ($req['type'] == 1) {
            $this->question_bank
                ->set('question_bank_status', 9)
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Soal gagal dihapus.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 0,
                    'id' => [$req['parent']],
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'delete', 'menghapus soal pada "' .$req['title'] .'"');
                
                $res = [
                    'head' => '',
                    'msg' => 'Soal berhasil dihapus.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 0,
                    'id' => [$req['parent']],
                ];
            }
            echo json_encode($res);
        } else if ($req['type'] == 2) {
            $this->question_bank
                ->set('question_bank_status', 9)
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->orWhere('question_bank_parent_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Soal gagal dihapus.',
                    'icon' => 'error',
                    'collapse' => 0,
                    'id' => [0]
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'delete', 'menghapus judul soal "' .$req['title'] .'" beserta selururh soal');

                $res = [
                    'head' => '',
                    'msg' => 'Soal berhasil dihapus.',
                    'icon' => 'success',
                    'collapse' => 0,
                    'id' => [0]
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == 3) {
            $this->question_bank
                ->set('question_bank_hint', '<p><br></p>')
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Petunjuk Soal gagal dihapus.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['parent']],
                    'chid' => $req['id']
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'delete', 'menghapus petunjuk pengerjaan soal');

                $res = [
                    'head' => '',
                    'msg' => 'Petunjuk Soal berhasil dihapus.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['parent']],
                    'chid' => $req['id']
                ];
            }

            echo json_encode($res);
        } else if ($req['type'] == 4) {
            $this->question_bank
                ->set('question_bank_explain', '<p><br></p>')
                ->set('question_bank_updated_by', userdata()['user_id'])
                ->where('question_bank_id', $req['id'])
                ->update();

            $sts = $this->question_bank->error();
            if ($sts['code'] > 0) {
                $res = [
                    'head' => '',
                    'msg' => 'Penjelasan Soal gagal dihapus.',
                    'icon' => 'error',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['parent']],
                    'chid' => $req['id']
                ];
            } else {
                $this->activity->store_log('Bank Soal Saya', 'delete', 'menghapus penjelasan pengerjaan soal');

                $res = [
                    'head' => '',
                    'msg' => 'Penjelasan Soal berhasil dihapus.',
                    'icon' => 'success',
                    'collapse' => 1,
                    'show_quest' => 1,
                    'id' => [$req['parent']],
                    'chid' => $req['id']
                ];
            }

            echo json_encode($res);
        }
    }

    public function get_title_list()
    {
        $req = $this->request->getVar();
        $question = $this->question_bank
            ->select('question_bank_id, question_bank_title')
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_status < 9')
            ->where('question_bank_subject_id', $req['subj'])
            ->where('question_bank_grade', $req['grad'])
            ->where('question_bank_parent_id', 0)
            ->where('question_bank_id <> ' . $req['parent'])
            ->findAll();

        echo json_encode($question);
    }

    public function upload_task()
    {
        $req = $this->request->getVar();
        $file = $_FILES['task_upload']['tmp_name'];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file);
        $spreadsheet = $reader->load($file);


        // $all_task = [];
        $total_sheet = $spreadsheet->getSheetCount();
        $ctrue = $cfalse = 0;
        for ($i = 0; $i < $total_sheet; $i++) {
            $sheetData = $spreadsheet->setActiveSheetIndex($i)->toArray();
            $xlsObj = $spreadsheet->setActiveSheetIndex($i);

            $arrImages = [];
            foreach ($xlsObj->getDrawingCollection() as $key => $drawing) {
                $imagePath = $drawing->getPath();
                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageName = 'image_' . uniqid() . '.' . $extension;
                $imageCoor = $drawing->getCoordinates2();
                copy($imagePath, 'images/temp_upload/' . $imageName);
                $imagedata = file_get_contents('images/temp_upload/' . $imageName);
                $arrImages[$imageCoor] = base64_encode($imagedata);
                unlink('images/temp_upload/' . $imageName);
            }

            $this->question_bank->db->transBegin();

            try {
                $ii = 1;
                foreach ($sheetData as $k => $v) {
                    $arr_task = [];
                    if (
                        $v[0] != 'No' &&
                        ($v[2] != '' || $v[2] != null) &&
                        ($v[3] != '' || $v[3] != null) &&
                        ($v[1] != '' || $v[1] != null)
                    ) {
                        $arr_task['question_bank_school_id'] = userdata()['school_id'];
                        $arr_task['question_bank_teacher_id'] = userdata()['id_profile'];
                        $arr_task['question_bank_subject_id'] = $req['subject'];
                        $arr_task['question_bank_grade'] = $req['grade'];
                        $arr_task['question_bank_parent_id'] = $req['id_quest'];
                        $arr_task['question_bank_status'] = 1;
                        $arr_task['question_bank_hint'] = '<p><br></p>';
                        $arr_task['question_bank_explain'] = '<p><br></p>';
                        $arr_task['question_bank_poin'] = $v[1];
                        $arr_task['question_bank_created_by'] = userdata()['user_id'];

                        $img_q = array_key_exists("C" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["C" . $ii] . '"></p>' : '';
                        $arr_task['question_bank_question'] = '<p>' . $v[2] . '</p>' . $img_q;


                        if ($i == 0) {
                            $arr_task['question_bank_type'] = 1;

                            $img_opt_a = array_key_exists("E" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["E" . $ii] . '"></p>' : '';
                            $img_opt_b = array_key_exists("F" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["F" . $ii] . '"></p>' : '';
                            $img_opt_c = array_key_exists("G" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["G" . $ii] . '"></p>' : '';
                            $img_opt_d = array_key_exists("H" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["H" . $ii] . '"></p>' : '';
                            $img_opt_e = array_key_exists("I" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["I" . $ii] . '"></p>' : '';
                            $opt = [
                                array_key_exists(4, $v) ? '<p>' . $v[4] . '</p>' . $img_opt_a : '<p></p>',
                                array_key_exists(5, $v) ? '<p>' . $v[5] . '</p>' . $img_opt_b : '<p></p>',
                                array_key_exists(6, $v) ? '<p>' . $v[6] . '</p>' . $img_opt_c : '<p></p>',
                                array_key_exists(7, $v) ? '<p>' . $v[7] . '</p>' . $img_opt_d : '<p></p>',
                                array_key_exists(8, $v) ? '<p>' . $v[8] . '</p>' . $img_opt_e : '<p></p>',
                            ];

                            $arr_ans[0] = $opt[$v[3] - 1];
                            $arr_task['question_bank_answer'] = json_encode($arr_ans);

                            $clean_opt = array_diff($opt, ['<p></p>']);
                            $arr_task['question_bank_option'] = json_encode($clean_opt);
                        } else if ($i == 1) {
                            $arr_task['question_bank_type'] = 2;

                            $img_opt_a = array_key_exists("E" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["E" . $ii] . '"></p>' : '';
                            $img_opt_b = array_key_exists("F" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["F" . $ii] . '"></p>' : '';
                            $img_opt_c = array_key_exists("G" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["G" . $ii] . '"></p>' : '';
                            $img_opt_d = array_key_exists("H" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["H" . $ii] . '"></p>' : '';
                            $img_opt_e = array_key_exists("I" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["I" . $ii] . '"></p>' : '';
                            $opt = [
                                array_key_exists(4, $v) ? '<p>' . $v[4] . '</p>' . $img_opt_a : '<p></p>',
                                array_key_exists(5, $v) ? '<p>' . $v[5] . '</p>' . $img_opt_b : '<p></p>',
                                array_key_exists(6, $v) ? '<p>' . $v[6] . '</p>' . $img_opt_c : '<p></p>',
                                array_key_exists(7, $v) ? '<p>' . $v[7] . '</p>' . $img_opt_d : '<p></p>',
                                array_key_exists(8, $v) ? '<p>' . $v[8] . '</p>' . $img_opt_e : '<p></p>',
                            ];

                            $omcx = explode("&", $v[3]);
                            $arr_ans = [];
                            foreach ($omcx as $x) {
                                if (isset($v[$x + 2])) {
                                    $arr_ans[] = $opt[$x - 1];
                                } else {
                                    throw new \Exception('index tidak ada');
                                }
                            }

                            $arr_task['question_bank_answer'] = json_encode($arr_ans);

                            $clean_opt = array_diff($opt, ['<p></p>']);
                            $arr_task['question_bank_option'] = json_encode($clean_opt);
                        } else if ($i == 2) {
                            $arr_task['question_bank_type'] = 3;

                            $tf = $v[3] == 'Benar' ? 1 : 2;
                            $arr_task['question_bank_answer'] = json_encode([$tf]);
                            $arr_task['question_bank_option'] = json_encode([1, 2]);
                        }
                    }
                    if (count($arr_task) > 0) {
                        $this->question_bank->insert($arr_task);
                        $sts = $this->question_bank->error();
                        if ($sts['code'] > 0) {
                            $cfalse++;
                        } else {
                            $ctrue++;
                        }
                    }
                    $ii++;
                }
                $this->question_bank->db->transCommit();
            } catch (\Throwable $th) {
                $this->question_bank->db->transRollback();
                session()->setFlashdata('head', 'Gagal!');
                session()->setFlashdata('icon', 'danger');
                session()->setFlashdata('msg', 'Something went wrong!');
                session()->setFlashdata('hide', 10000);

                return redirect()->to('/teacher/question-bank/additional/view-content/' . $req['subject'] . '/' . $req['grade']);
            }
        }

        session()->setFlashdata('head', 'Sukses!');
        session()->setFlashdata('icon', 'info');
        session()->setFlashdata('msg', $ctrue . ' Soal berhasil diunggah, ' . $cfalse . ' Soal gagal diunggah');

        session()->setFlashdata('hide', 10000);
        
        $this->activity->store_log('Bank Soal Standar', 'upload', 'unggah bank soal excel ke "'.$req['title_quest'].'"');

        return redirect()->to('/teacher/question-bank/additional/view-content/' . $req['subject'] . '/' . $req['grade']);
    }

    // public function upload_task()
    // {
    //     $req = $this->request->getVar();

    //     $file = $_FILES['task_upload']['tmp_name'];

    //     $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file);
    //     $spreadsheet = $reader->load($file);

    //     $success = true;

    //     $total_sheet = $spreadsheet->getSheetCount();
    //     $all_task = [];
    //     for ($i = 0; $i < $total_sheet; $i++) {
    //         $sheetData = $spreadsheet->setActiveSheetIndex($i)->toArray();
    //         $xlsObj = $spreadsheet->setActiveSheetIndex($i);

    //         $arrImages = [];
    //         foreach ($xlsObj->getDrawingCollection() as $key => $drawing) {
    //             $imagePath = $drawing->getPath();
    //             $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    //             $imageName = 'image_' . uniqid() . '.' . $extension;
    //             $imageCoor = $drawing->getCoordinates2();
    //             copy($imagePath, 'images/temp_upload/' . $imageName);
    //             $imagedata = file_get_contents('images/temp_upload/' . $imageName);
    //             $arrImages[$imageCoor] = base64_encode($imagedata);
    //             unlink('images/temp_upload/' . $imageName);
    //         }

    //         $this->question_bank->db->transBegin();

    //         try {
    //             $arr_task = [];
    //             $ii = 1;

    //             foreach ($sheetData as $k => $v) {
    //                 if ($v[0] != 'No' && ($v[2] != '' || $v[2] != null) && ($v[3] != '' || $v[3] != null) && ($v[1] != '' || $v[1] != null)) {
    //                     $arr_task[$i . $ii]['question_bank_school_id'] = userdata()['school_id'];
    //                     $arr_task[$i . $ii]['question_bank_teacher_id'] = userdata()['id_profile'];
    //                     $arr_task[$i . $ii]['question_bank_subject_id'] = $req['subject'];
    //                     $arr_task[$i . $ii]['question_bank_grade'] = $req['grade'];
    //                     $arr_task[$i . $ii]['question_bank_parent_id'] = $req['id_quest'];
    //                     $arr_task[$i . $ii]['question_bank_status'] = 1;
    //                     $arr_task[$i . $ii]['question_bank_hint'] = '<p><br></p>';
    //                     $arr_task[$i . $ii]['question_bank_explain'] = '<p><br></p>';
    //                     $arr_task[$i . $ii]['question_bank_poin'] = $v[1];

    //                     $img_q = array_key_exists("C" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["C" . $ii] . '"></p>' : '';
    //                     $arr_task[$i . $ii]['question_bank_question'] = '<p>' . $v[2] . '</p>' . $img_q;


    //                     if ($i == 0) {
    //                         $arr_task[$i . $ii]['question_bank_type'] = 1;

    //                         $img_opt_a = array_key_exists("E" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["E" . $ii] . '"></p>' : '';
    //                         $img_opt_b = array_key_exists("F" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["F" . $ii] . '"></p>' : '';
    //                         $img_opt_c = array_key_exists("G" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["G" . $ii] . '"></p>' : '';
    //                         $img_opt_d = array_key_exists("H" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["H" . $ii] . '"></p>' : '';
    //                         $img_opt_e = array_key_exists("I" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["I" . $ii] . '"></p>' : '';
    //                         $opt = [
    //                             array_key_exists(4, $v) ? '<p>' . $v[4] . '</p>' . $img_opt_a : '<p></p>',
    //                             array_key_exists(5, $v) ? '<p>' . $v[5] . '</p>' . $img_opt_b : '<p></p>',
    //                             array_key_exists(6, $v) ? '<p>' . $v[6] . '</p>' . $img_opt_c : '<p></p>',
    //                             array_key_exists(7, $v) ? '<p>' . $v[7] . '</p>' . $img_opt_d : '<p></p>',
    //                             array_key_exists(8, $v) ? '<p>' . $v[8] . '</p>' . $img_opt_e : '<p></p>',
    //                         ];

    //                         $arr_ans[0] = $opt[$v[3] - 1];
    //                         $arr_task[$i . $ii]['question_bank_answer'] = json_encode($arr_ans);

    //                         $clean_opt = array_diff($opt, ['<p></p>']);
    //                         $arr_task[$i . $ii]['question_bank_option'] = json_encode($clean_opt);
    //                     } else if ($i == 1) {
    //                         $arr_task[$i . $ii]['question_bank_type'] = 2;

    //                         $img_opt_a = array_key_exists("E" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["E" . $ii] . '"></p>' : '';
    //                         $img_opt_b = array_key_exists("F" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["F" . $ii] . '"></p>' : '';
    //                         $img_opt_c = array_key_exists("G" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["G" . $ii] . '"></p>' : '';
    //                         $img_opt_d = array_key_exists("H" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["H" . $ii] . '"></p>' : '';
    //                         $img_opt_e = array_key_exists("I" . $ii, $arrImages) ? '<p><img src="data:image/png;base64,' . $arrImages["I" . $ii] . '"></p>' : '';
    //                         $opt = [
    //                             array_key_exists(4, $v) ? '<p>' . $v[4] . '</p>' . $img_opt_a : '<p></p>',
    //                             array_key_exists(5, $v) ? '<p>' . $v[5] . '</p>' . $img_opt_b : '<p></p>',
    //                             array_key_exists(6, $v) ? '<p>' . $v[6] . '</p>' . $img_opt_c : '<p></p>',
    //                             array_key_exists(7, $v) ? '<p>' . $v[7] . '</p>' . $img_opt_d : '<p></p>',
    //                             array_key_exists(8, $v) ? '<p>' . $v[8] . '</p>' . $img_opt_e : '<p></p>',
    //                         ];

    //                         $omcx = explode("&", $v[3]);
    //                         $arr_ans = [];
    //                         foreach ($omcx as $x) {
    //                             if (isset($v[$x + 2])) {
    //                                 $arr_ans[] = $opt[$x - 1];
    //                             } else {
    //                                 throw new \Exception('index tidak ada');
    //                             }
    //                         }

    //                         $arr_task[$i . $ii]['question_bank_answer'] = json_encode($arr_ans);

    //                         $clean_opt = array_diff($opt, ['<p></p>']);
    //                         $arr_task[$i . $ii]['question_bank_option'] = json_encode($clean_opt);
    //                     } else if ($i == 2) {
    //                         $arr_task[$i . $ii]['question_bank_type'] = 3;

    //                         $tf = $v[3] == 'Benar' ? 1 : 2;
    //                         $arr_task[$i . $ii]['question_bank_answer'] = json_encode([$tf]);
    //                         $arr_task[$i . $ii]['question_bank_option'] = json_encode([1, 2]);
    //                     }
    //                 }
    //                 $ii++;
    //             }
    //             $this->question_bank->insertBatch($arr_task);
    //             $this->question_bank->db->transCommit();
    //         } catch (\Throwable $th) {
    //             $success = false;
    //             echo '<pre>';
    //             print_r($th);
    //             echo '</pre>';
    //             die;
    //             $this->question_bank->db->transRollback();
    //         }
    //     }

    //     session()->setFlashdata('head', 'Sukses!');
    //     session()->setFlashdata('icon', 'success');
    //     if ($success == true) {
    //         session()->setFlashdata('msg', 'Soal berhasil di unggah');
    //     } else {
    //         session()->setFlashdata('msg', 'Soal gagal di unggah');
    //     }
    //     session()->setFlashdata('hide', 3000);

    //     return redirect()->to('/teacher/question-bank/additional/view-content/' . $req['subject'] . '/' . $req['grade']);
    // }
}
