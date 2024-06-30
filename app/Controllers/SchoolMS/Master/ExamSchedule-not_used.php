<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\ExamScheduleModel;

class ExamSchedule extends BaseController
{
    
    protected $title;
    protected $exam_schedule;

    public function __construct()
    {
        $this->title = "Master";
        $this->exam_schedule = new ExamScheduleModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal Ujian';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Jadwal Ujian',
        ];

        $data['days'] = get_list('days');

        $data['row'] = $this->exam_schedule
        ->where('exam_schedule_status < 9')
        ->where('exam_schedule_school_id', userdata()['school_id'])
        ->findAll();

        return view("schoolms/exam_schedule/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal Ujian';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/exam-schedule' => 'Jadwal Ujian',
            '##' => 'Tambah Jadwal Ujian',
        ];
        
        $data['days'] = get_list('days');

        return view("schoolms/exam_schedule/create", $data);
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
                    'rules' => 'required|my_unique[master.exam_schedule.time-mts>'.$req['time1'].'-order>'.$req['order'].'-day>'.$req['day'].']',
                    'errors' => [
                        'required' => 'Kolom waktu akhir harus diisi',
                        'my_unique' => 'Jadwal sudah tersedia'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_exam_schedule = [
            'exam_schedule_school_id' => userdata()['school_id'],
            'exam_schedule_day' => htmlspecialchars($req['day']),
            'exam_schedule_order' => htmlspecialchars($req['order']),
            'exam_schedule_time' => $req['time1'].' - '.$req['time2'],
            'exam_schedule_status' => 1,
        ];

        $insert = $this->exam_schedule->save($ins_exam_schedule);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah jadwal ujian berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah jadwal ujian gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/exam-schedule/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Jadwal Ujian';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/exam-schedule' => 'Jadwal Ujian',
            '##' => 'Ubah Jadwal Ujian',
        ];
        
        $data['days'] = get_list('days');
        $data['row'] = $this->exam_schedule->where('exam_schedule_id', $id)->first();

        return view("schoolms/exam_schedule/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->exam_schedule
            ->where('exam_schedule_day', $req['day'])
            ->where('exam_schedule_order', $req['order'])
            ->where('exam_schedule_time', $req['time1'].' - '.$req['time2'])
            ->first();

        if ($old) {
            $exam_schedule_rule = 'required|my_unique[master.exam_schedule.time-mts>'.$req['time1'].'-order>'.$req['order'].'-day>'.$req['day'].']';
        } else {
            $exam_schedule_rule = 'required';
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
                    'rules' => $exam_schedule_rule,
                    'errors' => [
                        'required' => 'Kolom waktu akhir harus diisi',
                        'my_unique' => 'Jadwal sudah tersedia'
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->exam_schedule
        ->where("exam_schedule_id", $req["exam_schedule_id"])
        ->set("exam_schedule_day", htmlspecialchars($req['day']))
        ->set("exam_schedule_order", htmlspecialchars($req['order']))
        ->set("exam_schedule_time", $req['time1'].' - '.$req['time2'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah jadwal ujian berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah jadwal ujian gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/exam-schedule/');
    }

    public function destroy($id)
    {
        $delete = $this->exam_schedule
        ->where('exam_schedule_id', $id)
        ->set('exam_schedule_status', 9)
        ->update();

        if ($delete) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Hapus jadwal ujian berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Gagal!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Hapus jadwal ujian gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/exam-schedule/');
    }

}