<?php

namespace App\Controllers\Configs;

use App\Controllers\BaseController;
use App\Models\Configs\MenuModel;
use App\Models\Configs\AccessModel;

class Menu extends BaseController
{
    protected $menu;
    protected $access;
    protected $title;
    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->access = new AccessModel();
        $this->title = "Config";
    }
    public function index()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '##' => 'Menu',
        ];

        $data['menu'] = $this->menu
        ->where('menu_parent is null')
        ->where('menu_status < 9')
        ->findAll();

        return view("config/menu/index", $data);
    }

    public function add_menu()
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '##' => 'Tambah Menu',
        ];

        $data['parent'] = $this->menu->where('menu_parent is null')->findAll();
        return view("config/menu/add_menu", $data);
    }
   
    public function add_submenu($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';

        $menu = $this->menu->where('menu_id', $id)->first();
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$id => 'Sub Menu '. $menu['menu_name'],
            '##' => 'Tambah Sub Menu'
        ];

        $data['menu'] = $menu['menu_id'];

        $data['parent'] = $this->menu->where('menu_parent is null')->findAll();
        return view("config/menu/add_submenu", $data);
    }

    public function add_method($id, $parent)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$parent => 'Sub Menu '. $this->menu->where('menu_id', $parent)->first()['menu_name'],
            '/config/menu/method/'.$id.'/'.$parent => 'Method '. $this->menu->where('menu_id', $id)->first()['menu_name'],
            '##' => 'Tambah Method'
        ];

        $data['parent'] = $parent;
        $data['id'] = $id;
        
        return view("config/menu/add_method", $data);
    }

    public function save()
    {
        $req = $this->request->getVar();
        $redirect = '';
        if (isset($req["parent"]) && $req['parent'] != "") {
            if (
                !$this->validate([
                    "name" => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama harus diisi',
                        ]
                    ],
                    "url" => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom url harus diisi',
                        ]
                    ],
                ])
            ) {
                return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
            }

            $redirect = isset($req['method_']) ? 'method/' . $req['parent'] .'/'.$req['submenu'] : 'submenu/' . $req['parent'];
        } else {
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

        }

        $insert = $this->menu->save([
            'menu_parent' => empty($req['parent']) ? null : $req['parent'],
            'menu_name' => htmlspecialchars($req['name']),
            'menu_icon' => isset($req['icon']) ? htmlspecialchars($req['icon']) : '',
            'menu_url' => isset($req['url']) ? htmlspecialchars($req['url']) : '',
            'menu_created_by' => userdata()['user_id'],
            'menu_status' => 1,
        ]);

        if ($insert) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Tambah menu berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Tambah menu gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/menu/'.$redirect);
    }

    public function edit($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '##' => 'Ubah Menu',
        ];

        $data['menu'] = $this->menu->find($id);
        $data['parent'] = $this->menu->where('menu_parent is null')->findAll();

        return view("config/menu/edit_menu", $data);

    }

    public function edit_submenu($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';

        $menu = $this->menu->where('menu_id', $id)->first();
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$id => 'Sub Menu '. $menu['menu_name'],
            '##' => 'Ubah Sub Menu'
        ];

        $data['menu'] = $this->menu->find($id);
        $data['parent'] = $menu['menu_parent'];

        return view("config/menu/edit_submenu", $data);

    }

    public function edit_method($menu_id, $id, $parent)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';

        $menu = $this->menu->where('menu_id', $id)->first();
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$parent => 'Sub Menu '. $this->menu->where('menu_id', $parent)->first()['menu_name'],
            '/config/menu/method/'.$id.'/'.$parent => 'Method '. $this->menu->where('menu_id', $id)->first()['menu_name'],
            '##' => 'Edit Method'
        ];

        $data['menu'] = $this->menu->find($menu_id);
        $data['parent'] = $menu['menu_parent'];

        $data['parent_id'] = $parent;
        $data['id'] = $id;

        return view("config/menu/edit_method", $data);

    }

    public function update()
    {
        $req = $this->request->getVar();
        $redirect = '';
        if (isset($req["parent"]) && $req["parent"] != "") {
            if (
                !$this->validate([
                    "name" => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama harus diisi',
                        ]
                    ],
                    "url" => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom url harus diisi',
                        ]
                    ],
                ])
            ) {
                return redirect()->back()->withInput()->with('valid', $this->validator->getErrors());
            }
            $redirect = isset($req['method_']) ? 'method/' . $req['parent'] .'/'.$req['submenu'] : 'submenu/' . $req['parent'];
        } else {
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

        }

        $update = $this->menu
        ->where("menu_id", $req["menu_id"])
        ->set("menu_name", $req["name"])
        ->set("menu_icon", isset($req["icon"]) ? $req['icon'] : '')
        ->set("menu_url", isset($req["url"]) ? $req["url"] : '')
        ->set("menu_parent", empty($req['parent']) ? null : $req['parent'])
        ->set("menu_updated_by", userdata()['user_id'])
        ->update();

        if ($update) {
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', 'Berhasil mengubah menu');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Error!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', 'Gagal mengubah menu');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/menu/'.$redirect);
    }

    public function delete($id)
    {
        $delete = $this->menu
        ->where('menu_id', $id)
        ->set('menu_status', 9)
        ->set("menu_updated_by", userdata()['user_id'])
        ->update();

        if ($delete) {
            $this->access->where('access_menu_id', $id)->delete();
            
            session()->setFlashdata('head', 'Sukses!');
            session()->setFlashdata('icon', 'success');
            session()->setFlashdata('msg', '<b>Hapus menu</b> berhasil');
            session()->setFlashdata('hide', 3000);
        } else {
            session()->setFlashdata('head', 'Gagal!');
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('msg', '<b>Hapus menu</b> gagal');
            session()->setFlashdata('hide', 3000);
        }

        return redirect()->to('/config/menu/'.$this->request->getVar('mtd'));
    }

    public function submenu($id)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$id => 'Sub Menu '. $this->menu->where('menu_id', $id)->first()['menu_name'],
        ];

        $data['id'] = $id;
        
        $data['submenu'] = $this->menu
        ->where('menu_parent', $id)
        ->where('menu_status < 9')
        ->findAll();
        
        return view("config/menu/submenu", $data);
    }
    
    public function method($id, $parent)
    {
        $data["title"] = $this->title;
        $data["sidebar"] = 'Menu';
        $data["breadcrumb"] = [
            '#' => $this->title,
            '/config/menu' => 'Menu',
            '/config/menu/submenu/'.$parent => 'Sub Menu '. $this->menu->where('menu_id', $parent)->first()['menu_name'],
            '##' => 'Method '. $this->menu->where('menu_id', $id)->first()['menu_name'],
        ];
        
        $data['submenu'] = $this->menu
        ->where('menu_parent', $id)
        ->where('menu_status < 9')
        ->findAll();

        $data['parent'] = $parent;
        $data['id'] = $id;
        
        return view("config/menu/method", $data);
    }
    
    public function status()
    {
        $req = $this->request->getVar();
        $nsts = $req['sts'] == 1 ? 0 : 1;

        $msg = $nsts > 0 ? "aktifkan" : "nonaktifkan";
        $this->menu
        ->where("menu_id", $req['id'])
        ->set("menu_status", $nsts)
        ->set("menu_updated_by", userdata()['user_id'])
        ->update();

        echo json_encode(['msg'=>$msg, 'sts'=>true]);
    }
}
