<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\StudentGroupModel;
use App\Models\Masters\MajorModel;

class StudentGroup extends BaseController
{
    
    protected $title;
    protected $student_group;
    protected $major;
    public function __construct()
    {
        $this->title = "Master";
        $this->student_group = new StudentGroupModel();
        $this->major = new MajorModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Kelas Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Kelas Siswa',
        ];

        
        $data['row'] = $this->student_group
        ->where('student_group_status < 9')
        ->where('student_group_school_id', userdata()['school_id'])
        ->findAll();

        return view("schoolms/student_group/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Kelas Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/student-group' => 'Kelas Siswa',
            '##' => 'Tambah Kelas Siswa',
        ];
        
        $data['grade'] = get_list('grade')[school_level()];
        $data['major'] = $this->major
            ->where('major_school_id', userdata()['school_id'])
            ->where('major_status < 9')
            ->findAll();

        return view("schoolms/student_group/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        $ls_grade = implode(',',array_keys(get_list('grade')[school_level()]));
        $msg_additional = $req['major'] != '' ? ' dan jurusan '.major_name($req['major']) : '';
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required|my_unique[master.student_group.name-grade>'.$req['grade'].'-major_id>'.$req['major'].']',
                    'errors' => [
                        'required' => 'Kolom nama rombongan belajar harus diisi',
                        'my_unique' => 'Rombongan belajar '.$req['name'].' sudah terdaftar untuk kelas '.$req['grade'].$msg_additional,
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[' . $ls_grade . ']',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_student_group = [
            'student_group_school_id' => userdata()['school_id'],
            'student_group_major_id' => $req['major'],
            'student_group_grade' => $req['grade'],
            'student_group_name' => htmlspecialchars($req['name']),
            'student_group_quota' => htmlspecialchars($req['quota']),
            'student_group_description' => htmlspecialchars($req['desc']),
            'student_group_status' => 1,
            'student_group_created_by' => userdata()['user_id'],
        ];

        $insert = $this->student_group->save($ins_student_group);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah kelas berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah kelas gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/student-group/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Kelas Siswa';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/student-group' => 'Kelas Siswa',
            '##' => 'Ubah Kelas Siswa',
        ];
        
        $data['grade'] = get_list('grade')[school_level()];
        $data['major'] = $this->major
            ->where('major_school_id', userdata()['school_id'])
            ->where('major_status < 9')
            ->findAll();

        $data['row'] = $this->student_group->where('student_group_id', $id)->first();

        return view("schoolms/student_group/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $ls_grade = implode(',',array_keys(get_list('grade')[school_level()]));

        $old = $this->student_group
            ->where('student_group_name', $req['name'])
            ->where('student_group_grade', $req['grade'])
            ->where('student_group_major_id', $req['major'])
            ->first();

        $msg_additional = $req['major'] != '' ? ' dan jurusan '.major_name($req['major']) : '';
        if ($old) {
            $subject_rule = 'required|my_unique[master.student_group.name-grade>'.$req['grade'].'-major_id>'.$req['major'].']';
        } else {
            $subject_rule = 'required';
        }

        if (
            !$this->validate([
                "name" => [
                    'rules' => $subject_rule,
                    'errors' => [
                        'required' => 'Kolom nama rombongan belajar pelajaran harus diisi',
                        'my_unique' => 'Rombongan belajar '.$req['name'].' sudah terdaftar untuk kelas '.$req['grade'].$msg_additional,
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[' . $ls_grade . ']',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->student_group
        ->where("student_group_id", $req["student_group_id"])
        ->set("student_group_major_id", htmlspecialchars($req['major']))
        ->set("student_group_grade", htmlspecialchars($req['grade']))
        ->set("student_group_name", htmlspecialchars($req['name']))
        ->set("student_group_quota", htmlspecialchars($req['quota']))
        ->set("student_group_description", htmlspecialchars($req['desc']))
        ->set("student_group_updated_by", userdata()['user_id'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah kelas berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah kelas gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/student-group/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $this->student_group
            ->where('student_group_id', $id)
            ->set('student_group_status', 9)
            ->set("student_group_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->student_group
        ->where("student_group_id", $req['id'])
        ->set("student_group_status", $nsts)
        ->set("student_group_updated_by", userdata()['user_id'])
        ->update();

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}