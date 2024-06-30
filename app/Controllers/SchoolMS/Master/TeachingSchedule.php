<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\TeachingScheduleModel;

class TeachingSchedule extends BaseController
{
    
    protected $title;
    protected $teaching_schedule;

    public function __construct()
    {
        $this->title = "Master";
        $this->teaching_schedule = new TeachingScheduleModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal KBM';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Jadwal KBM',
        ];

        $data['days'] = get_list('days');

        $data['row'] = $this->teaching_schedule
        ->where('teaching_schedule_status < 9')
        ->where('teaching_schedule_school_id', userdata()['school_id'])
        ->findAll();

        return view("schoolms/teaching_schedule/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal KBM';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/teaching-schedule' => 'Jadwal KBM',
            '##' => 'Tambah Jadwal KBM',
        ];
        
        $data['days'] = get_list('days');

        return view("schoolms/teaching_schedule/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();

        if (
            !$this->validate([
                "day" => [
                    'rules' => "in_list[1,2,3,4,5,6,7]",
                    'errors' => [
                        'in_list' => 'Kolom hari harus dipilih',
                    ]
                ],
                "order" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]',
                    'errors' => [
                        'in_list' => 'Kolom jam ke harus dipilih',
                    ]
                ],
                "time1" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom waktu mulai harus diisi',
                    ]
                ],
                "time2" => [
                    'rules' => 'required|my_unique[master.teaching_schedule.time-mts>'.$req['time1'].'-order>'.$req['order'].'-day>'.$req['day'].']',
                    'errors' => [
                        'required' => 'Kolom waktu akhir harus diisi',
                        'my_unique' => 'Jadwal sudah tersedia'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_teaching_schedule = [
            'teaching_schedule_school_id' => userdata()['school_id'],
            'teaching_schedule_day' => htmlspecialchars($req['day']),
            'teaching_schedule_order' => htmlspecialchars($req['order']),
            'teaching_schedule_time' => $req['time1'].' - '.$req['time2'],
            'teaching_schedule_status' => 1,
        ];

        $insert = $this->teaching_schedule->save($ins_teaching_schedule);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah jadwal KBM berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah jadwal KBM gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/teaching-schedule/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal KBM';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/teaching-schedule' => 'Jadwal KBM',
            '##' => 'Ubah Jadwal KBM',
        ];
        
        $data['days'] = get_list('days');
        $data['row'] = $this->teaching_schedule->where('teaching_schedule_id', $id)->first();
        
        return view("schoolms/teaching_schedule/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->teaching_schedule
            ->where('teaching_schedule_day', $req['day'])
            ->where('teaching_schedule_order', $req['order'])
            ->where('teaching_schedule_time', $req['time1'].' - '.$req['time2'])
            ->first();

        if ($old) {
            $teaching_schedule_rule = 'required|my_unique[master.teaching_schedule.time-mts>'.$req['time1'].'-order>'.$req['order'].'-day>'.$req['day'].']';
        } else {
            $teaching_schedule_rule = 'required';
        }
        
        if (
            !$this->validate([
                "day" => [
                    'rules' => "in_list[1,2,3,4,5,6,7]",
                    'errors' => [
                        'in_list' => 'Kolom hari harus dipilih',
                    ]
                ],
                "order" => [
                    'rules' => 'in_list[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]',
                    'errors' => [
                        'in_list' => 'Kolom jam ke harus dipilih',
                    ]
                ],
                "time1" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom waktu mulai harus diisi',
                    ]
                ],
                "time2" => [
                    'rules' => $teaching_schedule_rule,
                    'errors' => [
                        'required' => 'Kolom waktu akhir harus diisi',
                        'my_unique' => 'Jadwal sudah tersedia'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->teaching_schedule
        ->where("teaching_schedule_id", $req["teaching_schedule_id"])
        ->set("teaching_schedule_day", htmlspecialchars($req['day']))
        ->set("teaching_schedule_order", htmlspecialchars($req['order']))
        ->set("teaching_schedule_time", $req['time1'].' - '.$req['time2'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah jadwal KBM berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah jadwal KBM gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/teaching-schedule/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $this->teaching_schedule
            ->where('teaching_schedule_id', $id)
            ->set('teaching_schedule_status', 9)
            ->set("teaching_schedule_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

}