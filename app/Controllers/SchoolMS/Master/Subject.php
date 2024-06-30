<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\SubjectModel;
use App\Models\Masters\MajorModel;

class Subject extends BaseController
{
    
    protected $title;
    protected $subject;
    protected $major;

    public function __construct()
    {
        $this->title = "Master";
        $this->subject = new SubjectModel();
        $this->major = new MajorModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Mata Pelajaran';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Mata Pelajaran',
        ];

        $data['grade'] = get_list('grade')[school_level()];
        
        $data['row'] = $this->subject
        ->where('subject_status < 9')
        ->where('subject_school_id', userdata()['school_id'])
        ->findAll();

        return view("schoolms/subject/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Mata Pelajaran';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/subject' => 'Mata Pelajaran',
            '##' => 'Tambah Mata Pelajaran',
        ];
        
        $data['grade'] = get_list('grade')[school_level()];
        $data['major'] = $this->major
            ->where('major_school_id', userdata()['school_id'])
            ->where('major_status < 9')
            ->findAll();

        return view("schoolms/subject/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        $msg_additional = $req['major'] != '' ? ' dan jurusan '.major_name($req['major']) : '';
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required|my_unique[master.subject.name-grade>'.$req['grade'].'-major_id>'.$req['major'].']',
                    'errors' => [
                        'required' => 'Kolom mata pelajaran harus diisi',
                        'my_unique' => 'Mata pelajaran '.$req['name'].' sudah terdaftar untuk kelas '.$req['grade'].$msg_additional,
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
                "option" => [
                    'rules' => 'in_list[1,2]',
                    'errors' => [
                        'in_list' => 'Kolom tipe mata pelajaran harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_subject = [
            'subject_school_id' => userdata()['school_id'],
            'subject_major_id' => $req['major'],
            'subject_name' => htmlspecialchars($req['name']),
            'subject_grade' => htmlspecialchars($req['grade']),
            'subject_description' => htmlspecialchars($req['desc']),
            'subject_option' => htmlspecialchars($req['option']),
            'subject_status' => 1,
            'subject_created_by' => userdata()['user_id'],
            
        ];

        $insert = $this->subject->save($ins_subject);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah mata pelajaran berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah mata pelajaran gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/subject/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Mata Pelajaran';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/subject' => 'Mata Pelajaran',
            '##' => 'Ubah Mata Pelajaran',
        ];
        
        $data['grade'] = get_list('grade')[school_level()];
        $data['row'] = $this->subject->where('subject_id', $id)->first();
        $data['major'] = $this->major
        ->where('major_school_id', userdata()['school_id'])
        ->where('major_status < 9')
        ->where('major_status', 1)
        ->findAll();

        return view("schoolms/subject/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->subject
            ->where('subject_name', $req['name'])
            ->where('subject_grade', $req['grade'])
            ->where('subject_major_id', $req['major'])
            ->first();

        $msg_additional = $req['major'] != '' ? ' dan jurusan '.major_name($req['major']) : '';
        if (!$old) {
            $subject_rule = 'required|my_unique[master.subject.name-grade>'.$req['grade'].'-major_id>'.$req['major'].']';
        } else {
            $subject_rule = 'required';
        }

        if (
            !$this->validate([
                "name" => [
                    'rules' => $subject_rule,
                    'errors' => [
                        'required' => 'Kolom mata pelajaran harus diisi',
                        'my_unique' => 'Mata pelajaran '.$req['name'].' sudah terdaftar untuk kelas '.$req['grade'].$msg_additional,
                    ]
                ],
                "grade" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12]',
                    'errors' => [
                        'in_list' => 'Kolom kelas harus dipilih',
                    ]
                ],
                "option" => [
                    'rules' => 'in_list[1,2]',
                    'errors' => [
                        'in_list' => 'Kolom tipe mata pelajaran harus dipilih',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->subject
        ->where("subject_id", $req["subject_id"])
        ->set("subject_major_id", htmlspecialchars($req['major']))
        ->set("subject_name", htmlspecialchars($req['name']))
        ->set("subject_option", htmlspecialchars($req['option']))
        ->set("subject_grade", htmlspecialchars($req['grade']))
        ->set("subject_description", htmlspecialchars($req['desc']))
        ->set("subject_updated_by", userdata()['user_id'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah mata pelajaran berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah mata pelajaran gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/subject/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $this->subject
            ->where('subject_id', $id)
            ->set('subject_status', 9)
            ->set("subject_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->subject
        ->where("subject_id", $req['id'])
        ->set("subject_status", $nsts)
        ->set("subject_updated_by", userdata()['user_id'])
        ->update();

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}