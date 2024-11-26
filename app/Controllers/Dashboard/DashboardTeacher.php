<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class DashboardTeacher extends BaseController
{
    protected $title;
    public function __construct()
    {
        $this->title = "Dashboard";

    }
    public function index()
    {
        $data = array();
        $data["title"] = $this->title;
        $data["page"] = "";
        $data["sidebar"] = "Guru";
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Guru',
        ];

        $data['user'] = userdata();
        # filter tahun ajaran & semester
        # total guru 
        # total mapel
        # total siswa
        # total rombel



        return view("dashboard/teacher", $data);
    }

    public function change_password()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Guru';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/dashboard/school' => 'Guru',
            '##' => 'Ubah Password',
        ];

        return view("dashboard/password", $data);
    }

    public function update_password()
    {
        if (
            !$this->validate([
                "old_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password harus diisi',
                    ]
                ],
                "new_password" => [
                    'rules' => "required|trim|min_length[8]",
                    'errors' => [
                        'required' => 'Kolom password baru harus diisi',
                        'min_length' => 'Minimal password harus 8 karakater',
                    ]
                ],
                "repeat_password" => [
                    'rules' => 'required|trim|matches[new_password]',
                    'errors' => [
                        'required' => 'Kolom ulangi password harus diisi',
                        'matches' => 'Password tidak sama'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }
        
        $req = $this->request->getVar();
        $upd = change_pass($req);

        if ($upd['status']) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', $upd['msg']);
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to(userdata()['change_password']);
    }
   
}
