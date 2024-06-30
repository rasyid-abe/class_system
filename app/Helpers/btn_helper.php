<?php
// function button_add($uri)
// {
//     $db = \Config\Database::connect();

//     $role = session()->get('role');
//     $menu_id = $db->query("SELECT menu_id FROM account_menu WHERE menu_url = '". $uri."'")->getRow('menu_id');
//     if ($menu_id) {
//         $access = $db->query("SELECT * FROM account_access WHERE access_role_id = $role AND access_menu_id = $menu_id")->getNumRows();
//         if ($access > 0) {
//             return '<a href="'.base_url($uri).'"class="btn btn-sm btn-primary btn-round ml-auto"><i class="fa fa-plus"></i> Tambah</a>';
//         }
//     }
// }

function button_add($url)
{

    $role = session()->get('role');
    if ($role < 4) {
        return '<a href="'.base_url($url).'" class="btn btn-light-primary me-3 btn-sm"><i class="fa fa-plus"></i> Tambah</a>';
    }
}

function button_export($url)
{

    $role = session()->get('role');
    if ($role < 4) {
        return '<form action="'.base_url($url).'" method="post" class="d-inline">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-sm btn-light-success btn-round"><i
                class="fa fa-download"></i> Export</button>
    </form>';
    }
}

function button_import()
{
    $role = session()->get('role');
    if ($role < 4) {
        return '
        <a href="#" class="btn btn-light-warning btn-active-light btn-flex btn-center btn-sm"
        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"><i class="fa fa-upload"></i> Import</a>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px"
            data-kt-menu="true">
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal_insert">Data Baru</a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal_update">Ubah Masal</a>
            </div>
        </div>
        ';
        // return '<button class="btn btn-light-warning btn-sm btn-round" data-bs-toggle="modal" data-bs-target="#modal_view">
        //     <i class="fa fa-upload"></i>
        //     Import
        // </button>';
    }
}

function button_edit($url)
{

    $role = session()->get('role');
    if ($role < 4) {
        return '<a href="'.base_url($url).'" class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top"
        title="Edit"><i class="fas fa-pencil-alt"></i></a>';
    }
}

function button_detail($url)
{

    $role = session()->get('role');
    if ($role < 4) {
        return '<a href="'.base_url($url).'"
        class="btn btn-sm btn-icon btn-success" data-toggle="tooltip" data-placement="top"
        title="Sub Menu"><i class="fa fa-list"></i></a>';
    }
}
function button_semester($url)
{

    $role = session()->get('role');
    if ($role < 4) {
        return '<a href="'.base_url($url).'"
        class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top"
        title="Data Semester"><i class="fa fa-list"></i></a>';
    }
}

function button_delete($url,$id)
{
    $role = session()->get('role');
    if ($role < 4) {
        return '<button class="btn btn-sm btn-icon btn-danger delete" data-url="'.$url.'" data-id="'.$id.'" data-toggle="tooltip"
        data-placement="top" title="Nonaktifkan"><i class="fa fa-trash"></i></button>';
    }
}
function button_delete_OLD($url)
{
    $role = session()->get('role');
    if ($role < 4) {
        return '<form class="d-inline" action="'.base_url($url).'" method="POST"> 
        <?= csrf_field(); ?> 
        <input type="hidden" name="mtd" value="">
        <input type="hidden" name="_method" value="DELETE">
        <button class="btn btn-sm btn-icon btn-danger"
            onclick="delete();" type="submit"
            data-toggle="tooltip" data-placement="top" title="Hapus"><i
                class="fa fa-trash"></i></button>
        </form>';
    }
}

function button_activate($url, $status)
{
    $role = session()->get('role');
    if ($role < 4) {
        if ($status == 1) {
            $btn = '<button class="btn btn-xs btn-info" type="submit" data-toggle="tooltip"
            data-placement="top" title="Nonaktifkan"><i class="fa fa-toggle-off"></i></button>';
        } else {
            $btn = '<button class="btn btn-xs btn-info" type="submit" data-toggle="tooltip"
            data-placement="top" title="Aktifkan"><i class="fa fa-toggle-on"></i></button>';
        }

        return '<form class="d-inline"
            action="'.base_url($url).'"
            method="POST">
            <?= csrf_field(); ?>
            <input type="hidden" name="mtd" value="">
            '.$btn.'
        </form>';
    }
}


function button_reset_password($id)
{
    return '<div class="btn btn-sm btn-icon btn-info" onclick="reset_password('.$id.')" data-toggle="tooltip" data-placement="top"
    title="Reset Password"><i class="fas fa-key"></i></div>';
}

function button_credential($url, $id)
{
    return '<div class="btn btn-sm btn-icon btn-primary credential" data-url="'.$url.'" data-id="'.$id.'" data-toggle="tooltip" data-placement="top"
    title="Informasi Login"><i class="fas fa-lock"></i></div>';
}


