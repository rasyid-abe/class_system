<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\SemesterModel;

class Semester extends BaseController
{
    
    protected $title;
    protected $semester;

    public function __construct()
    {
        $this->title = "Master";
        $this->semester = new SemesterModel();
    }

    public function index($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Tahun Ajaran';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/school-year' => 'Tahun Ajaran',
            '##' => 'Semester',
        ];

        $data['row'] = $this->semester
        ->where('semester_status < 9')
        ->where('semester_school_id', userdata()['id_profile'])
        ->findAll();

        $data['id_ta'] = $id;

        return view("schoolms/semester/index", $data);
    }
    
    public function create($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Tahun Ajaran';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/school-year' => 'Tahun Ajaran',
            '/sms/master/semester/'.$id => 'Semester',
            '##' => 'Tambah Semester',
        ];
        
        $data['grade'] = get_list('grade');
        $data['id_ta'] = $id;

        return view("schoolms/semester/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();
        
        if (
            !$this->validate([
                "semester_name" => [
                    'rules' => 'required|my_unique[master.semester.name]',
                    'errors' => [
                        'required' => 'Kolom semester harus dipilih',
                        'my_unique' => 'Semester sudah terdaftar',
                    ]
                ],
                "start_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal mulai harus diisi',
                    ]
                ],
                "end_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_semester = [
            'semester_school_id' => userdata()['id_profile'],
            'semester_school_period_id' => $req['id_ta'],
            'semester_name' => htmlspecialchars($req['semester_name']),
            'semester_start_date' => htmlspecialchars($req['start_date']),
            'semester_end_date' => htmlspecialchars($req['end_date']),
            'semester_status' => 1,
            'semester_created_by' => userdata()['user_id'],
        ];

        $insert = $this->semester->save($ins_semester);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah tahun ajaran berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah tahun ajaran gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/semester/'. $req['id_ta']);
    }

    public function edit($id_ta, $id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Semester';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/school-year' => 'Tahun Ajaran',
            '/sms/master/semester/'.$id_ta => 'Semester',
            '##' => 'Ubah Semester',
        ];
        
        $data['row'] = $this->semester->where('semester_id', $id)->first();
        $data['id_ta'] = $id_ta;

        return view("schoolms/semester/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->semester->where('semester_id', $req['semester_id'])->first();
        $period_rule = $old['semester_name'] == $req['semester_name'] ? 'required' : 'required|my_unique[master.semester.name]';

        if (
            !$this->validate([
                "semester_name" => [
                    'rules' => $period_rule,
                    'errors' => [
                        'required' => 'Kolom semester harus dipilih',
                        'my_unique' => 'Semester sudah terdaftar',
                    ]
                ],
                "start_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal mulai harus diisi',
                    ]
                ],
                "end_date" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->semester
        ->where("semester_id", $req["semester_id"])
        ->set("semester_name", htmlspecialchars($req['semester_name']))
        ->set("semester_start_date", htmlspecialchars($req['start_date']))
        ->set("semester_end_date", htmlspecialchars($req['end_date']))
        ->set("semester_updated_by", userdata()['user_id'])
        ->update();
        
        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah tahun ajaran berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah tahun ajaran gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/semester/'.$req['id_ta']);
    }

    public function destroy($id_ta, $id)
    {
        $delete = $this->semester
        ->where('semester_id', $id)
        ->set('semester_status', 9)
        ->set("semester_updated_by", userdata()['user_id'])
        ->update();

        if ($delete) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Hapus tahun ajaran berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Gagal!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Hapus tahun ajaran gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/semester/'.$id_ta);
    }
}