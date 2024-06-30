<?php

namespace App\Controllers\Configs;

use App\Controllers\BaseController;
use App\Models\Configs\AccessModel;
use App\Models\Configs\RoleModel;
use App\Models\Configs\MenuModel;

class Role extends BaseController
{
    protected $role;
    protected $menu;
    protected $access;

    protected $title;
    public function __construct()
    {
        $this->access = new AccessModel();
        $this->menu = new MenuModel();
        $this->role = new RoleModel();
        $this->title = "Config";
    }

    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Role';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Role',
        ];

        $data['role'] = $this->role->where('role_status < 9')->findAll();
        
        return view("config/role/index", $data);
    }

    public function add()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Role';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/role' => 'Role',
            '##' => 'Tambah Role'
        ];

        return view('config/role/add', $data);
    }

    public function save()
    {
        $req = $this->request->getVar();
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $insert = $this->role->save([
            'role_name' => htmlspecialchars($req['name']),
            'role_slug' => str_replace(' ', '-', strtolower($req['name'])),
            'role_description' => $req['desc'],
            'role_status' => 1,
        ]);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah role berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah role gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/role/');
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Role';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/role' => 'Role',
            '##' => 'Ubah Role',
        ];

        $data['role'] = $this->role->find($id);

        return view("config/role/edit", $data);

    }

    public function update()
    {
        $req = $this->request->getVar();
        if (
            !$this->validate([
                "name" => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama harus diisi',
                    ]
                ],
            ])
        ) {
            return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
        }

        $update = $this->role
        ->where('role_id', $req['role_id'])
        ->set('role_name', htmlspecialchars($req['name']))
        ->set('role_slug', str_replace(' ', '-', strtolower($req['name'])))
        ->set('role_description', $req['desc'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Ubah role berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Ubah role gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/role/');
    }

    public function delete($id)
    {
        $delete = $this->role
        ->where('role_id', $id)
        ->set('role_status', 9)
        ->update();

        if ($delete) {
            $this->access->where('access_role_id', $id)->delete();
            
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', '<b>Hapus role</b> berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Gagal!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', '<b>Hapus role</b> gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/role/');
    }
    
    public function access($role)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Role';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/role' => 'Role',
            '##' => 'Akses Role '. $this->role->where('role_id', $role)->first()['role_name'],
        ];

        $data['role'] = $role;

        $menu = $this->menu
        ->where('menu_parent is null')
        ->where('menu_status', 1)
        ->findAll();
        $data['menu'] = $menu;

        $submenu = [];
        foreach ($menu as $k => $v) {
            $submenu[$k] = $this->menu
            ->where('menu_parent', $v['menu_id'])
            ->where('menu_status', 1)
            ->findAll();
            
            $method = [];
            foreach ($submenu[$k] as $i => $val) {
                $method[$i] = $this->menu
                ->where('menu_parent', $val['menu_id'])
                ->where('menu_status', 1)
                ->findAll();

                array_push($submenu[$k][$i], $method[$i]);
            }

        }
        $data['submenu'] = $submenu;

        return view("config/role/access", $data);
    }

    public function change_access()
    {
        $req = $this->request->getVar();

        $data = [
            "access_role_id" => $req["role"],
            "access_menu_id" => $req["menu"]  
        ];

        $chk = $this->access->where($data)->findAll();

        if (count($chk) < 1) {
            $this->access->save($data);
        } else {
            $this->access->where($data)->delete();
        }

        echo true;
    }
}