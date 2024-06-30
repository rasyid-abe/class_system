<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\SchoolYearModel;

class SchoolYear extends BaseController
{
    
    protected $title;
    protected $school_year;

    public function __construct()
    {
        $this->title = "Master";
        $this->school_year = new SchoolYearModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Tahun Akademik';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Tahun Akademik',
        ];

        $data['row'] = $this->school_year
        ->where('school_year_status < 9')
        ->where('school_year_school_id', userdata()['id_profile'])
        ->findAll();

        return view("schoolms/school_year/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Tahun Akademik';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/school-year' => 'Tahun Akademik',
            '##' => 'Tambah Tahun Akademik',
        ];
        
        $data['grade'] = get_list('grade');

        return view("schoolms/school_year/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        if (
            !$this->validate([
                "year_period" => [
                    'rules' => 'required|my_unique[master.school_year.period]',
                    'errors' => [
                        'required' => 'Kolom tahun ajaran harus diisi',
                        'my_unique' => 'Tahun ajaran sudah terdaftar',
                    ]
                ],
                "start_date_one" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal awal semester gasal harus diisi',
                    ]
                ],
                "end_date_one" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir semester gasal harus diisi',
                    ]
                ],
                "start_date_two" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal awal semester genap harus diisi',
                    ]
                ],
                "end_date_two" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir semester genap harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_school_year = [
            'school_year_school_id' => userdata()['id_profile'],
            'school_year_period' => htmlspecialchars($req['year_period']),
            'school_year_status' => 1,
            'school_year_start_date_one' => htmlspecialchars($req['start_date_one']),
            'school_year_end_date_one' => htmlspecialchars($req['end_date_one']),
            'school_year_start_date_two' => htmlspecialchars($req['start_date_two']),
            'school_year_end_date_two' => htmlspecialchars($req['end_date_two']),
            'school_year_created_by' => userdata()['user_id'],
        ];

        $insert = $this->school_year->save($ins_school_year);

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

        return redirect()->to('/sms/master/school-year/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Tahun Akademik';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/school-year' => 'Tahun Akademik',
            '##' => 'Ubah Tahun Akademik',
        ];
        
        $data['row'] = $this->school_year->where('school_year_id', $id)->first();

        return view("schoolms/school_year/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->school_year->where('school_year_id', $req['school_year_id'])->first();
        $period_rule = $old['school_year_period'] == $req['year_period'] ? 'required' : 'required|my_unique[master.school_year.period]';

        if (
            !$this->validate([
                "year_period" => [
                    'rules' => $period_rule,
                    'errors' => [
                        'required' => 'Kolom tahun ajaran harus diisi',
                        'my_unique' => 'Tahun ajaran sudah terdaftar',
                    ]
                ],
                "start_date_one" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal awal semester gasal harus diisi',
                    ]
                ],
                "end_date_one" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir semester gasal harus diisi',
                    ]
                ],
                "start_date_two" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal awal semester genap harus diisi',
                    ]
                ],
                "end_date_two" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom tanggal akhir semester genap harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->school_year
        ->where("school_year_id", $req["school_year_id"])
        ->set("school_year_period", htmlspecialchars($req['year_period']))
        ->set("school_year_start_date_one", htmlspecialchars($req['start_date_one']))
        ->set("school_year_end_date_one", htmlspecialchars($req['end_date_one']))
        ->set("school_year_start_date_two", htmlspecialchars($req['start_date_two']))
        ->set("school_year_end_date_two", htmlspecialchars($req['end_date_two']))
        ->set("school_year_updated_by", userdata()['user_id'])
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

        return redirect()->to('/sms/master/school-year/');
    }

        public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $this->school_year
            ->where('school_year_id', $id)
            ->set('school_year_status', 9)
            ->set("school_year_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }
}