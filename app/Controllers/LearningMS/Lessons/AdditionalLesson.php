<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\AdditionalLessonModel;
use App\Models\Masters\SubjectModel;

class AdditionalLesson extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $subject;
    protected $lesson_additional;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->sidebar = "Additional";
        $this->lesson_additional = new AdditionalLessonModel();
        $this->subject = new SubjectModel();
    }

    public function index()
    {
        $data["title"] = 'Materi Tambahan';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Materi Tambahan',
        ];

        $data['additional'] = $this->lesson_additional
            ->where('lesson_additional_teacher_id', userdata()['id_profile'])
            ->where('lesson_additional_status < 9')
            ->findAll();

        return view("learningms/lesson_additional/index", $data);
    }

    public function create()
    {
        $data["title"] = 'Tambah Materi';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/additional' => 'Materi Tambahan',
            '##' => 'Tambah Materi',
        ];

        $data['subject'] = $this->subject
            ->whereIn('subject_school_id', [-1,userdata()['school_id']])
            ->findAll();
        $data['grade'] = get_list('grade')[school_level(userdata()['school_id'])];

        return view("learningms/lesson_additional/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        $ids = $this->subject
            ->select('subject_id')
            ->whereIn('subject_school_id', [-1,userdata()['school_id']])
            ->findAll();
        $ids_subject = implode(",", array_column($ids,"subject_id"));

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
                    'rules' => 'in_list['.$ids_subject.']',
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

        $ins_additional = [
            'lesson_additional_school_id' => userdata()['school_id'],
            'lesson_additional_teacher_id' => userdata()['id_profile'],
            'lesson_additional_subject_id' => $req['subject'],
            'lesson_additional_grade' => $req['grade'],
            'lesson_additional_type' => $req['doc_type'],
            'lesson_additional_chapter' => htmlspecialchars($req['chapter']),
            'lesson_additional_subchapter' => htmlspecialchars($req['sub_chapter']),
            'lesson_additional_path' => $req['link'],
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

        return redirect()->to('/teacher/lesson/additional');
    }

    public function edit($id)
    {
        $data["title"] = 'Tambah Materi';
        $data["sidebar"] = $this->sidebar;
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/teacher/lesson/additional' => 'Materi Tambahan',
            '##' => 'Ubah Materi',
        ];
        $data['grade'] = get_list('grade');
        $data['row'] = $this->lesson_additional->where('lesson_additional_id', $id)->first();
        $data['subject'] = $this->subject
            ->whereIn('subject_school_id', [-1,userdata()['school_id']])
            ->findAll();
        $data['grade'] = get_list('grade')[school_level(userdata()['school_id'])];


        return view("learningms/lesson_additional/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $ids = $this->subject
            ->select('subject_id')
            ->whereIn('subject_school_id', [-1,userdata()['school_id']])
            ->findAll();
        $ids_subject = implode(",", array_column($ids,"subject_id"));

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
                    'rules' => 'in_list['.$ids_subject.']',
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

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}