<?php

namespace App\Controllers\Configs;

use App\Controllers\BaseController;
use App\Models\Configs\MenuShortcutModel;
use App\Models\Configs\MenuModel;
use App\Models\Configs\AccessModel;

class MenuShortcut extends BaseController
{
    protected $menu_shortcut;
    protected $menu;
    protected $access;
    protected $title;
    public function __construct()
    {
        $this->menu_shortcut = new MenuShortcutModel();
        $this->menu = new MenuModel();
        $this->access = new AccessModel();
        $this->title = "Config";
    }

    public function get_menu()
    {
        $req = $this->request->getVar();
        $res = [];
        $res['type'] = 'parent';

        $data = '';
        $where = [];
        $where['menu_parent'] = null;
        if ($req['menu_id']) {
            $res['type'] = 'child';
            $res['parent'] = $req['menu_id'];
            $where['menu_parent'] = $req['menu_id'];
    
            $data = [
                "menu_shortcut_user_id" => userdata()['user_id'],
            ];
            $this->menu_shortcut->select('menu_shortcut_menu_id');
            $chk = $this->menu_shortcut->where($data)->findAll();
            $ids = array_column($chk, 'menu_shortcut_menu_id');
            
            $data = $this->menu
                ->where($where)
                ->where('menu_name not in ("Dashboard", "Master", "Config")')
                ->findAll();
    
            foreach ($data as $k => $v) {
                if (in_array($v['menu_id'], $ids)) {
                    $data[$k]['checked'] = 1;
                } else {
                    $data[$k]['checked'] = 0;
                }
            }
        } else {
            $data = $this->menu
                ->where($where)
                ->where('menu_name not in ("Dashboard", "Master", "Config")')
                ->findAll();
        }

        $res['data'] = $data;
            
        echo json_encode($res);
    }

    public function shortcut_store()
    {
        $req = $this->request->getVar();
        
        $data = [
            "menu_shortcut_user_id" => userdata()['user_id'],
            "menu_shortcut_menu_id" => $req["menu"]  
        ];

        $chk = $this->menu_shortcut->where($data)->findAll();

        if (count($chk) < 1) {
            $this->menu_shortcut->save($data);
        } else {
            $this->menu_shortcut->where($data)->delete();
        }

        echo true;
    }

    public function show_shortcut()
    {
        $data = [
            "menu_shortcut_user_id" => userdata()['user_id'],
        ];

        $this->menu_shortcut->select('menu_shortcut_menu_id');
        $chk = $this->menu_shortcut->where($data)->findAll();
        $menu_ids = array_column($chk, 'menu_shortcut_menu_id');

        $menu = "";
        if ($menu_ids) {
            $this->menu->whereIn('menu_id', $menu_ids);
            $menu = $this->menu->findAll();
        }

        echo json_encode($menu);
    }

}
