<?php

namespace App\Controllers\LearningMS\Lessons;

use App\Controllers\BaseController;
use App\Models\Lessons\StandartLessonModel;
use App\Models\Masters\SubjectModel;

class AdditionalLesson extends BaseController
{

    protected $title;
    protected $sidebar;
    protected $subject;
    protected $standart_lesson;

    public function __construct()
    {
        $this->title = "Materi Pelajaran";
        $this->sidebar = "Additional";
        $this->standart_lesson = new StandartLessonModel();
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
        dd($req);
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required|my_unique[master.major.name]',
                    'errors' => [
                        'required' => 'Kolom jurusan harus diisi',
                        'my_unique' => 'Jurusan sudah terdaftar',
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        // $ins_major = [
        //     'major_school_id' => userdata()['school_id'],
        //     'major_name' => htmlspecialchars($req['name']),
        //     'major_description' => htmlspecialchars($req['desc']),
        //     'major_created_by' => userdata()['user_id'],
        //     'major_status' => 1,
        // ];

        // $insert = $this->major->save($ins_major);

        // if ($insert) {
        //     session()->setFlashdata('head', 'Sukses!');
        //     session()->setFlashdata('icon', 'success');
        //     session()->setFlashdata('msg', 'Tambah jurusan berhasil');
        //     session()->setFlashdata('hide', 3000);
        // } else {
        //     session()->setFlashdata('head', 'Error!');
        //     session()->setFlashdata('icon', 'error');
        //     session()->setFlashdata('msg', 'Tambah jurusan gagal');
        //     session()->setFlashdata('hide', 3000);
        // }

        return redirect()->to('/sms/master/major/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jurusan';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/major' => 'Jurusan',
            '##' => 'Ubah Jurusan',
        ];

        $data['grade'] = get_list('grade');
        $data['row'] = $this->major->where('major_id', $id)->first();

        return view("schoolms/major/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->major->where('major_id', $req['major_id'])->first();
        $major_rule = $old['major_name'] == $req['name'] ? 'required' : 'required|my_unique[master.major.name]';

        if (
            !$this->validate([
                "name" => [
                    'rules' => $major_rule,
                    'errors' => [
                        'required' => 'Kolom jurusan harus diisi',
                        'my_unique' => 'Jurusan sudah terdaftar',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->major
            ->where("major_id", $req["major_id"])
            ->set("major_name", htmlspecialchars($req['name']))
            ->set("major_description", htmlspecialchars($req['desc']))
            ->set("major_updated_by", userdata()['user_id'])
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

        return redirect()->to('/sms/master/major/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $remove = $this->major
            ->where('major_id', $id)
            ->set('major_status', 9)
            ->set("major_updated_by", userdata()['user_id'])
            ->update();

        // if ($remove) {
            
        // }

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->major
        ->where("major_id", $req['id'])
        ->set("major_status", $nsts)
        ->set("major_updated_by", userdata()['user_id'])
        ->update();

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}