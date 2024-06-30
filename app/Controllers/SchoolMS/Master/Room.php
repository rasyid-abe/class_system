<?php

namespace App\Controllers\SchoolMS\Master;

use App\Controllers\BaseController;
use App\Models\Masters\RoomModel;

class Room extends BaseController
{
    
    protected $title;
    protected $room;

    public function __construct()
    {
        $this->title = "Master";
        $this->room = new RoomModel();
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Ruang Belajar';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Ruang Belajar',
        ];

        $data['row'] = $this->room
        ->where('room_status < 9')
        ->where('room_school_id', userdata()['school_id'])
        ->findAll();

        return view("schoolms/room/index", $data);
    }
    
    public function create()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Ruang Belajar';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/room' => 'Ruang Belajar',
            '##' => 'Tambah Ruang',
        ];
        
        $data['grade'] = get_list('grade');

        return view("schoolms/room/create", $data);
    }

    public function store()
    {
        $req = $this->request->getVar();
        
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required|my_unique[master.room.name]',
                    'errors' => [
                        'required' => 'Kolom ruang belajar harus diisi',
                        'my_unique' => 'Ruang belajar sudah terdaftar',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $ins_room = [
            'room_school_id' => userdata()['school_id'],
            'room_name' => htmlspecialchars($req['name']),
            'room_capacity' => htmlspecialchars($req['capacity']),
            'room_description' => htmlspecialchars($req['desc']),
            'room_status' => 1,
            'room_created_by' => userdata()['user_id'],
        ];

        $insert = $this->room->save($ins_room);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah ruang belajar berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah ruang belajar gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/room/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Ruang Belajar';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/sms/master/room' => 'Ruang Belajar',
            '##' => 'Ubah Ruang',
        ];
        
        $data['grade'] = get_list('grade');
        $data['row'] = $this->room->where('room_id', $id)->first();

        return view("schoolms/room/edit", $data);
    }

    public function update()
    {
        $req = $this->request->getVar();
        $old = $this->room->where('room_id', $req['room_id'])->first();
        $room_rule = $old['room_name'] == $req['name'] ? 'required' : 'required|my_unique[master.room.name]';

        if (
            !$this->validate([
                "name" => [
                    'rules' => $room_rule,
                    'errors' => [
                        'required' => 'Kolom ruang belajar harus diisi',
                        'my_unique' => 'Ruang belajar sudah terdaftar',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->room
        ->where("room_id", $req["room_id"])
        ->set("room_name", htmlspecialchars($req['name']))
        ->set("room_capacity", htmlspecialchars($req['capacity']))
        ->set("room_description", htmlspecialchars($req['desc']))
        ->set("room_updated_by", userdata()['user_id'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah ruang belajar berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah ruang belajar gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/sms/master/room/');
    }

    public function destroy()
    {
        $id = $this->request->getVar()['id'];

        $this->room
            ->where('room_id', $id)
            ->set('room_status', 9)
            ->set("room_updated_by", userdata()['user_id'])
            ->update();

        echo json_encode(['msg' => 'dihapus', 'sts' => true]);
    }

    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->room
        ->where("room_id", $req['id'])
        ->set("room_status", $nsts)
        ->set("room_updated_by", userdata()['user_id'])
        ->update();

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}