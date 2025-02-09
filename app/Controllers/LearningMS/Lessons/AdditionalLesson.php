<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\QuestionBank\QuestionBankModel;
use App\Models\QuestionBank\StandartQuestionBankModel;
use App\Models\QuestionBank\PublicQuestionBankModel;
use App\Models\Systems\TeacherAssignModel;
use App\Models\Profiles\TeacherModel;
use App\Models\Masters\SubjectModel;

class AdditionalLesson extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $page;
    protected $teacher_subject;
    protected $lesson_additional;
    protected $teacher;
    protected $subject;
    protected $qb;
    protected $qb_s;
    protected $qb_p;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->page = "Lesson";
        $this->sidebar = "Additional";
        $this->lesson_additional = new AdditionalLessonModel();
        $this->teacher_subject = new TeacherAssignModel();
        $this->teacher = new TeacherModel();
        $this->subject = new SubjectModel();
        $this->qb = new QuestionBankModel();
        $this->qb_s = new StandartQuestionBankModel();
        $this->qb_p = new PublicQuestionBankModel();
    }

    public function index()
    {
        $data["title"] = 'Materi Saya';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Saya',
        ];
            
        $mysubs = $this->teacher_subject
            ->select('teacher_assign_id, teacher_assign_grade, subject_id, subject_name')
            ->join('master_subject', 'teacher_assign_subject_id=subject_id', 'left')
            ->where('teacher_assign_school_id', userdata()['school_id'])
            ->where('teacher_assign_teacher_id', userdata()['id_profile'])
            ->where('teacher_assign_status < 9')
            // ->where('teacher_assign_school_year_id', year_active()['school_year_id'])
            ->orderBy('teacher_assign_grade')
            ->findAll();

        $subs = [];
        foreach ($mysubs as $k => $v) {
            $subs[$v['subject_id']]['subj_id'] = $v['subject_id'];
            $subs[$v['subject_id']]['subj_name'] = $v['subject_name'];
            $subs[$v['subject_id']]['grade'][$v['teacher_assign_grade']] = $v['teacher_assign_grade'];
        }

        $data['mysubs'] = $subs;
        return view("learningms/lesson_additional/index", $data);
    }

    public function first_page()
    {
        $req = $this->request->getVar();

        $total_subchap = $this->lesson_additional
            ->select('count(*)')
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_school_id', userdata()['school_id'])
            ->where('lesson_additional_teacher_id', userdata()['id_profile'])
            ->where('lesson_additional_subchapter != ""')
            ->groupBy('lesson_additional_chapter, lesson_additional_subchapter, lesson_additional_grade')
            ->findAll();
        $total_chapter = $this->lesson_additional
            ->select('count(*)')
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_school_id', userdata()['school_id'])
            ->where('lesson_additional_teacher_id', userdata()['id_profile'])
            ->groupBy('lesson_additional_chapter')
            ->findAll();

        $res = [
            't_chap' => count($total_chapter),
            't_subchap' => count($total_subchap),
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
            '/teacher/lesson/additional' => 'Materi Saya',
            '##' => $subs['subject_name'] . ' - Kelas ' . $grade,
        ];

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        $chapter = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter')
            ->where('lesson_additional_teacher_id', userdata()['id_profile'])
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_subject_id', $subject)
            ->where('lesson_additional_grade', $grade)
            ->groupBy('lesson_additional_chapter')
            ->findAll();
            
        foreach ($chapter as $k => $v) {
            $sub_chapter = $this->lesson_additional
                ->where('lesson_additional_chapter', $v['lesson_additional_chapter'])
                ->where('lesson_additional_status < 9')
                ->findAll();

            $chapter[$k]['sub_chapter'] = $sub_chapter;
        }

        $data['chapters'] = $chapter;
        $data['teachers'] = $this->teacher
            ->select('teacher_id, teacher_first_name, teacher_last_name, teacher_degree')
            ->where('teacher_school_id', userdata()['school_id'])
            ->where('teacher_id <> '. userdata()['id_profile'])
            ->findAll();

        return view("learningms/lesson_additional/content", $data);
    }

    public function create($subject, $grade)
    {
        $data["title"] = 'Tambah Materi';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/additional' => 'Materi Saya',
            '##' => 'Tambah Materi',
        ];

        $data['babs'] = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter')
            ->where('lesson_additional_subject_id', $subject)
            ->where('lesson_additional_grade', $grade)
            ->where('lesson_additional_status < 9')
            ->groupBy('lesson_additional_chapter')
            ->findAll();

        $data['subject'] = $subject;
        $data['grade'] = $grade;

        return view("learningms/lesson_additional/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        $babs = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter')
            ->where('lesson_additional_subject_id', $req['subject'])
            ->where('lesson_additional_grade', $req['grade'])
            ->where('lesson_additional_status < 9')
            ->findAll();

        $list_bab = implode(",", array_column($babs, "lesson_additional_chapter"));

        $chap_down = 'in_list[' . $list_bab . ']';
        $chap1st = $chap2nd = 'permit_empty';
        $val_chap = $req['chapter'];

        if ($req['chapter'] == -1) {
            $chap_down = 'permit_empty';
            $chap1st = 'permit_empty';
            $chap2nd = 'required';
            $val_chap = $req['chap_2nd'];
        } elseif ($req['chapter'] == 0) {
            $chap_down = 'in_list[' . $list_bab . ']';
            $chap1st = 'permit_empty';
            $chap2nd = 'permit_empty';
        } elseif ($req['chapter'] == -2) {
            $chap_down = 'permit_empty';
            $chap1st = 'required';
            $chap2nd = 'permit_empty';
            $val_chap = $req['chap_1st'];
        }

        if (
            !$this->validate([
                "chapter" => [
                    'rules' => $chap_down,
                    'errors' => [
                        'in_list' => 'Kolom BAB harus dipilih',
                    ]
                ],
                "chap_1st" => [
                    'rules' => $chap1st,
                    'errors' => [
                        'required' => 'Kolom BAB harus diisi',
                    ]
                ],
                "chap_2nd" => [
                    'rules' => $chap2nd,
                    'errors' => [
                        'required' => 'Kolom BAB harus diisi',
                    ]
                ],
                "sub_chapter" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom Sub BAB harus diisi',
                    ]
                ]
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_additional = [
            'lesson_additional_school_id' => userdata()['school_id'],
            'lesson_additional_teacher_id' => userdata()['id_profile'],
            'lesson_additional_subject_id' => $req['subject'],
            'lesson_additional_grade' => $req['grade'],
            'lesson_additional_chapter' => htmlspecialchars($val_chap),
            'lesson_additional_subchapter' => htmlspecialchars($req['sub_chapter']),
            'lesson_additional_content_path' => $req['link'],
            'lesson_additional_content' => $req['content'],
            'lesson_additional_created_by' => userdata()['user_id'],
            'lesson_additional_status' => 1,
        ];

        $insert = $this->lesson_additional->save($ins_additional);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah jurusan berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah jurusan gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/teacher/lesson/additional/view-content/' . $req['subject'] . '/' . $req['grade']);
    }

    public function grab_chaps()
    {
        $id = $this->request->getVar('id');
        $r = $this->lesson_additional->where('lesson_additional_id', $id)->first();
        $data = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter')
            ->where('lesson_additional_teacher_id', userdata()['id_profile'])
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_subject_id', $r['lesson_additional_subject_id'])
            ->where('lesson_additional_grade', $r['lesson_additional_grade'])
            ->groupBy('lesson_additional_chapter')
            ->findAll();

        echo json_encode($data);
    }

    public function grab_content()
    {
        $req = $this->request->getVar();
        if ($req['type'] == 'shr') {
            $data = $this->lesson_additional
                ->select('
                    lesson_additional_id,
                    lesson_additional_shared_type,
                    lesson_additional_shared_to
                ')
                ->where('lesson_additional_id', $req['id'])
                ->where('lesson_additional_status < 9')
                ->first();
        } else {
            $data = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->where('lesson_additional_status < 9')
                ->first();
    
            $tasks = json_decode($data['lesson_additional_tasks']);
            
            $data['tasks'] = $tasks ? (array)$tasks : [];
            $data['attach_arr'] = $data['lesson_additional_attachment_path'] != '' ? array_values(json_decode($data['lesson_additional_attachment_path'], true)) : [];
        }
 
        echo json_encode($data);
    }
    
    public function grab_topic_content()
    {
        $id = $this->request->getVar('id');
        $data = $this->lesson_additional
            ->select('lesson_additional_content')
            ->where('lesson_additional_status < 9')
            ->where('lesson_additional_id', $id)
            ->first();

        echo json_encode($data);
    }

    public function update_content()
    {
        $req = $this->request->getVar();

        $update = false;
        if ($req['type'] == 1) {
            $update = $this->lesson_additional
                ->set('lesson_additional_chapter', $req['val'][0])
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_chapter', $req['id'])
                ->update();
        } elseif ($req['type'] == 2) {
            $update = $this->lesson_additional
                ->set('lesson_additional_chapter', $req['val'][0])
                ->set('lesson_additional_subchapter', $req['val'][1])
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_id', $req['id'])
                ->update();
        } elseif ($req['type'] == 3) {
            $arr_ins = [
                'lesson_additional_school_id' => userdata()['school_id'],
                'lesson_additional_teacher_id' => userdata()['id_profile'],
                'lesson_additional_subject_id' => $req['val'][1],
                'lesson_additional_grade' => $req['val'][2],
                'lesson_additional_chapter' => htmlspecialchars($req['val'][0]),
                'lesson_additional_subchapter' => htmlspecialchars($req['val'][3]),
                'lesson_additional_created_by' => userdata()['user_id'],
                'lesson_additional_status' => 1,
            ];

            $update = $this->lesson_additional->insert($arr_ins);
        } elseif ($req['type'] == 4) {
            $arr_ins = [
                'lesson_additional_school_id' => userdata()['school_id'],
                'lesson_additional_teacher_id' => userdata()['id_profile'],
                'lesson_additional_subject_id' => $req['val'][1],
                'lesson_additional_grade' => $req['val'][2],
                'lesson_additional_chapter' => htmlspecialchars($req['val'][0]),
                'lesson_additional_created_by' => userdata()['user_id'],
                'lesson_additional_status' => 1,
            ];

            $update = $this->lesson_additional->insert($arr_ins);
        } elseif ($req['type'] == 5) {
            $update = $this->lesson_additional
                ->set('lesson_additional_content', $req['val'][0])
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_id', $req['id'])
                ->update();
        } elseif ($req['type'] == 6) {
            $update = $this->lesson_additional
                ->set('lesson_additional_video_path', $req['val'][0])
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_id', $req['id'])
                ->update();
        } elseif ($req['type'] == 7) {
            $tasks = [];
            $tasks['std'] = $req['val'][0];
            $tasks['me'] = $req['val'][1];
            $tasks['pub'] = $req['val'][2];

            $update = $this->lesson_additional
                ->set('lesson_additional_tasks', json_encode($tasks))
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_id', $req['id'])
                ->update();
        }


        echo json_encode($update);
    }

    public function upload_content()
    {
        $req = $this->request->getVar();

        if ($req['type'] == 7) {
            $old = $this->lesson_additional
                ->select('lesson_additional_attachment_path')
                ->where('lesson_additional_id', $req['lesson_id'])
                ->first();

            $arr_file = [];
            if ($old['lesson_additional_attachment_path'] != '') {
                $arr_file = array_values(json_decode($old['lesson_additional_attachment_path'], true));
            }

            $attach = $this->request->getFileMultiple('file_attach');

            foreach ($attach as $file) {
                $path_dir = 'documents/lms/additional_lesson/attachment/';
                $upload_file_name = $path_dir . $req['subject'] . '^' . $req['grade'] . '^' .$file->getName();
                
                $temp_file = $file->getPathName();
                $up = s3_uploads($temp_file, $upload_file_name);
 
                array_push($arr_file, $upload_file_name);
                
                // if (!$file->isValid()) {
                //     return $file->getErrorString();
                // } else {
                //     $filename = $req['subject'] . '^' . $req['grade'] . '^' .$file->getName();
                //     $file->move('attachment', $filename);
                //     array_push($arr_file, $filename);
                // }
            }

            $update = $this->lesson_additional
                ->set('lesson_additional_attachment_path', json_encode($arr_file))
                ->set('lesson_additional_updated_by', userdata()['user_id'])
                ->where('lesson_additional_id', $req['lesson_id'])
                ->update();

            session()->setFlashdata('att_id', $req['lesson_id']);
        } else if ($req['type'] == 8) {
            $temp_file = $_FILES['file_attach']['tmp_name'];
            $file_name = basename($_FILES['file_attach']['name']);
            $file_type = explode('.', $file_name);
            $extention = end($file_type);

            $allowTypes = ['pdf'];
            $path_dir = 'documents/lms/additional_lessom/';
            if (in_array($extention, $allowTypes)) {
                $upload_file_name = $path_dir . $req['subject'] . '^' . $req['grade'] . '^' . str_replace(' ', '_', $file_name);
                
                $up = s3_uploads($temp_file, $upload_file_name);
                if ($up['status']) {
                    $old_file = $this->lesson_additional->select('lesson_additional_content_path')->where('lesson_additional_id', $req['lesson_id'])->first();
                    if ($old_file) {
                        s3_unlink($old_file['lesson_additional_content_path']);
                    }
                    $update = $this->lesson_additional
                        ->set('lesson_additional_content_path', $upload_file_name)
                        ->set('lesson_additional_updated_by', userdata()['user_id'])
                        ->where('lesson_additional_id', $req['lesson_id'])
                        ->update();

                    session()->setFlashdata('file_id', $req['lesson_id']);
                } else {
                    session()->setFlashdata('att_id', $req['lesson_id']);
                    session()->setFlashdata('upload_msg', $up['message']);
                }
            } else {
                session()->setFlashdata('att_id', $req['lesson_id']);
                session()->setFlashdata('upload_msg', $up['message']);
            }
            
        }

        return redirect()->to('/teacher/lesson/additional/view-content/' . $req['subject'] . '/' . $req['grade']);
    }

    public function remove_content()
    {
        $req = $this->request->getVar();
        $update = false;
        if ($req['type'] == 1) {
            $update = $this->lesson_additional
                ->where('lesson_additional_chapter', $req['file'])
                ->set('lesson_additional_status', 9)
                ->update();
        } elseif ($req['type'] == 2) {
            $update = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->set('lesson_additional_status', 9)
                ->update();
        } elseif ($req['type'] == 3) {
        } elseif ($req['type'] == 4) {
        } elseif ($req['type'] == 5) {
            $update = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->set('lesson_additional_content', null)
                ->update();
        } elseif ($req['type'] == 6) {
            $update = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->set('lesson_additional_video_path', null)
                ->update();

        } elseif ($req['type'] == 7) {
           
            $old = $this->lesson_additional
                ->select('lesson_additional_attachment_path')
                ->where('lesson_additional_id', $req['id'])
                ->first();

            $arr_file = [];
            if ($old['lesson_additional_attachment_path'] != '') {
                $arr_file = array_values(json_decode($old['lesson_additional_attachment_path'], true));
            }

            if ($req['file'] != null) {
                if (($key = array_search($req['file'], $arr_file)) !== false) {
                    unset($arr_file[$key]);
                }

                if (file_exists(FCPATH . '/attachment/' . $req['file'])) {
                    unlink(FCPATH . '/attachment/' . $req['file']);
                }

                $files = count($arr_file) > 0 ? json_encode($arr_file) : null;
                
                $update = $this->lesson_additional
                    ->set('lesson_additional_attachment_path', $files)
                    ->where('lesson_additional_id', $req['id'])
                    ->update();

                // session()->setFlashdata('att_id', $req['lesson_id']);

            } else {
                foreach ($arr_file as $k => $v) {
                    if (($key = array_search($v, $arr_file)) !== false) {
                        unset($arr_file[$key]);
                    }
    
                    if (file_exists(FCPATH . '/attachment/' . $v)) {
                        unlink(FCPATH . '/attachment/' . $v);
                    }
                }

                $update = $this->lesson_additional
                    ->set('lesson_additional_attachment_path', null)
                    ->where('lesson_additional_id', $req['id'])
                    ->update();
            }
        } elseif ($req['type'] == 8) {
            if (file_exists(FCPATH . '/lesson_file/' . $req['file'])) {
                unlink(FCPATH . '/lesson_file/' . $req['file']);
            }

            $update = $this->lesson_additional
                ->set('lesson_additional_content_path', null)
                ->where('lesson_additional_id', $req['id'])
                ->update();

            // session()->setFlashdata('file_id', $req['lesson_id']);
        } elseif ($req['type'] == 9) {
            $update = $this->lesson_additional
                ->where('lesson_additional_id', $req['id'])
                ->set('lesson_additional_tasks', null)
                ->update();
        }

        echo json_encode($update);
    }

    public function share_topic()
    {
        $req = $this->request->getVar();
        if ($req['val'] != 0) {
            $shared_to = '';
            if ($req['val'] == 4) {
                $shared_to = isset($req['thc']) != '' ? json_encode($req['thc']) : '';
            } 
    
            $share = $this->lesson_additional
                ->where('lesson_additional_id', $req['idd'])
                ->set('lesson_additional_shared_type', $req['val'])
                ->set('lesson_additional_shared_to', $shared_to)
                ->update();
        } else {
            $share = $this->lesson_additional
                ->where('lesson_additional_id', $req['idd'])
                ->set('lesson_additional_shared_type', $req['val'])
                ->set('lesson_additional_shared_to', '')
                ->update();
        }

        echo json_encode($share);
    }

    public function edit($id)
    {
        $data["title"] = 'Ubah Materi';
        $data["page"] = $this->page;
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/additional' => 'Materi Saya',
            '##' => 'Ubah Materi',
        ];

        $old = $this->lesson_additional->where('lesson_additional_id', $id)->first();
        $data['row'] = $old;
        $data['babs'] = $this->lesson_additional
            ->select('lesson_additional_id, lesson_additional_chapter')
            ->where('lesson_additional_subject_id', $old['lesson_additional_subject_id'])
            ->where('lesson_additional_grade', $old['lesson_additional_grade'])
            ->where('lesson_additional_status < 9')
            ->findAll();

        return view("learningms/lesson_additional/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $ids = $this->subject
            ->select('subject_id')
            ->whereIn('subject_school_id', [-1, userdata()['school_id']])
            ->findAll();
        $ids_subject = implode(",", array_column($ids, "subject_id"));

        if (
            !$this->validate([
                "chapter" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom BAB harus diisi',
                    ]
                ],
                "sub_chapter" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom Sub BAB harus diisi',
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
                "subject" => [
                    'rules' => 'in_list[' . $ids_subject . ']',
                    'errors' => [
                        'in_list' => 'Kolom mata pelajaran harus dipilih',
                    ]
                ],
                "doc_type" => [
                    'rules' => 'in_list[1,2,3]',
                    'errors' => [
                        'in_list' => 'Kolom tipe materi harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->lesson_additional
            ->where("lesson_additional_id", $req["lesson_additional_id"])
            ->set("lesson_additional_subject_id", $req['subject'])
            ->set("lesson_additional_grade", $req['grade'])
            ->set("lesson_additional_type", $req['doc_type'])
            ->set("lesson_additional_chapter", htmlspecialchars($req['chapter']))
            ->set("lesson_additional_subchapter", htmlspecialchars($req['sub_chapter']))
            ->set("lesson_additional_path", $req['link'])
            ->set("lesson_additional_content", $req['content'])
            ->set("lesson_additional_updated_by", userdata()['user_id'])
            ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah jurusan berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah jurusan gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/teacher/lesson/additional');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $remove = $this->lesson_additional
            ->where('lesson_additional_id', $id)
            ->set('lesson_additional_status', 9)
            ->set("lesson_additional_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->lesson_additional
            ->where("lesson_additional_id", $req['id'])
            ->set("lesson_additional_status", $nsts)
            ->set("lesson_additional_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => $msg, 'sts' => true]);
    }

    public function question_bank() 
    {
        $req = $this->request->getVar();

        $std = $this->qb_s
            ->select('question_bank_standart_id as id, question_bank_standart_title as title, "std" as source')
            ->where('question_bank_standart_subject_id', $req['subj'])
            ->where('question_bank_standart_grade', $req['grad'])
            ->where('question_bank_standart_parent_id', 0)
            ->where('question_bank_standart_status < 9')
            ->findAll();

        $me = $this->qb->select('question_bank_id as id, question_bank_title as title, "me" as source')
            ->where('question_bank_subject_id', $req['subj'])
            ->where('question_bank_grade', $req['grad'])
            ->where('question_bank_teacher_id', userdata()['id_profile'])
            ->where('question_bank_parent_id', 0)
            ->where('question_bank_status < 9')
            ->findAll();

        $pub = $this->qb_p->get_list_title(userdata()['id_profile'], [$req['subj']], [$req['grad']]);

        foreach ($std as $k => $v) {
            $ch_std = $this->qb_s
                ->select('question_bank_standart_id as id')
                ->where('question_bank_standart_parent_id', $v['id'])
                ->where('question_bank_standart_status < 9')
                ->findAll();

            $std[$k]['child'] = $ch_std;
        }

        foreach ($me as $k => $v) {
            $ch_me = $this->qb->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $me[$k]['child'] = $ch_me;
        }

        foreach ($pub as $k => $v) {
            $ch_pub = $this->qb->select('question_bank_id as id')
                ->where('question_bank_parent_id', $v['id'])
                ->where('question_bank_status < 9')
                ->findAll();

            $pub[$k]['child'] = $ch_pub;
        }

        $res = [
            'std' => ['head' => 'Bank Soal Standart', 'content' => $std],
            'me' => ['head' => 'Bank Soal Saya', 'content' => $me],
            'pub' => ['head' => 'Bank Soal Publik', 'content' => $pub],
        ];

        echo json_encode($res);
    }

    public function get_question()
    {
        $req = $this->request->getVar();

        $res = [];
        if ($req['type'] == 1) {
            $res = $this->qb_s
                ->select('
                    question_bank_standart_question as question,
                    question_bank_standart_option as option,
                    question_bank_standart_answer as answer,
                    question_bank_standart_explain as explain,
                    question_bank_standart_hint as hint,
                    question_bank_standart_hint as hint,
                    question_bank_standart_type as type,
                    question_bank_standart_id as id
                ')
                ->where('question_bank_standart_id', $req['id'])
                ->first();
        } else {
            $res = $this->qb
                ->select('
                    question_bank_question as question,
                    question_bank_option as option,
                    question_bank_answer as answer,
                    question_bank_explain as explain,
                    question_bank_hint as hint,
                    question_bank_type as type,
                    question_bank_id as id
                ')
                ->where('question_bank_id', $req['id'])
                ->first();
        }

        echo json_encode($res);
    }
}
