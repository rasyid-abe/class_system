<?php

function userdata()
{
    $db = \Config\Database::connect();

    $user = session()->get('c_id');
    $role = session()->get('c_role');

    if ($role == 11) {
        $select = "
            au.user_id,
            pt.teacher_school_id school_id,
            pt.teacher_id id_profile,
            CONCAT(pt.teacher_first_name, ' ', pt.teacher_last_name) name,
            pt.teacher_degree degree,
            pt.teacher_image image,
            ar.role_name
        ";
        $join = "LEFT JOIN profile_teacher pt ON au.user_id = pt.teacher_user_id";
        $user_role = 'teacher';
    } else if ($role == 12) {
        $select = "
            au.user_id,
            ps.student_school_id school_id,
            ps.student_id id_profile,
            CONCAT(ps.student_first_name, ' ', ps.student_last_name) name,
            ps.student_image image,
            ar.role_name
        ";
        $join = "LEFT JOIN profile_student ps ON au.user_id = ps.student_user_id";
        $user_role = 'student';
    }
    
    $sql = "
        SELECT ".$select." FROM account_user au
        LEFT JOIN account_role ar ON au.user_role_id = ar.role_id 
        $join
        WHERE au.user_id = $user 
    ";
    
    $row = $db->query($sql)->getRowArray();
    $row['img_path'] = 'images/'.$user_role.'/';
    $row['home'] = 'dashboard/'.$user_role.'/';
    $row['change_password'] = '/dashboard/'.$user_role.'/change-password';
    $row['update_password'] = '/dashboard/'.$user_role.'/update-password';
    $row['url_profile'] = '/dashboard/'.$user_role.'/show/'.$row['id_profile'];

    return $row;

}

function send_email($to, $content, $subject, $title)
{
    $email = service('email');
    $email->setTo($to);
    $email->setFrom('acidnain72@gmail.com', $title);
    $email->setSubject($subject);
    $email->setMessage($content);

    return $email->send();
}

function check_access($role, $menu)
{
    $db = \Config\Database::connect();
    $chk = $db->query("SELECT * FROM account_access WHERE access_role_id = " . $role . " AND access_menu_id = " . $menu)->getNumRows();

    if ($chk > 0) {
        return "checked='checked'";
    }
}

function check_status($status)
{
    return $status < 1 ? '' : "checked='checked'";
}

function get_list($filename)
{
    $json = file_get_contents(FCPATH . "assets/json/" . $filename . ".json");
    $json_data = json_decode($json, true);

    return $json_data;
}

function school_level($id)
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT school_level FROM profile_school WHERE school_id = " . $id . "")->getRowArray();

    return $query['school_level'];
}

function school_alias($id)
{
    $db = \Config\Database::connect();
    $query = $db->query("SELECT school_alias FROM profile_school WHERE school_id = " . $id . "")->getRowArray();

    return $query['school_alias'];
}

function territory_name($code)
{
    $db = \Config\Database::connect();
    $sql = "SELECT territory_name FROM data_territory WHERE territory_code = '$code'";

    return $db->query($sql)->getRow('territory_name');
}

function territory_code($name)
{
    $db = \Config\Database::connect();
    $sql = "SELECT territory_code FROM data_territory WHERE territory_name LIKE '%".$name."%' AND CHAR_LENGTH(territory_code) < 9";

    return $db->query($sql)->getRow('territory_code');
}

function major_name($id)
{
    $db = \Config\Database::connect();
    $sql = "SELECT major_name FROM master_major WHERE major_id = '$id'";

    return $db->query($sql)->getRow('major_name');
}

function random_char($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@$%^&*()_}{[]';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function change_pass($req)
{
    $db = \Config\Database::connect();
    $sql_p = "SELECT user_password FROM account_user WHERE user_id = ".session()->get('id');
    $old_p = $db->query($sql_p)->getRow('user_password');

    if (strlen($old_p) > 10) {
        $pass = password_verify($req['old_password'], $old_p);
    } else {
        $pass = $req['old_password'] === $old_p;
    }

    if ($pass) {
        $hash = password_hash($req['new_password'], PASSWORD_DEFAULT);
        $upd = "UPDATE account_user SET user_password = '". $hash ."' WHERE user_id = ".session()->get('id');
        if ($db->query($upd)) {
            return [
                'status' => true,
                'msg' => 'Password berhasil diubah.'
            ];
        } else {
            return [
                'status' => false,
                'msg' => 'Password gagal diubah'
            ];
        }
    } else {
        return [
            'status' => false,
            'msg' => 'Password lama salah'
        ];
    }
}

function teacher_user_id($id)
{
    $db = \Config\Database::connect();
    $sql = "SELECT teacher_user_id FROM profile_teacher WHERE teacher_id = '$id'";

    return $db->query($sql)->getRow('teacher_user_id');
}
function student_user_id($id)
{
    $db = \Config\Database::connect();
    $sql = "SELECT student_user_id FROM profile_student WHERE student_id = '$id'";

    return $db->query($sql)->getRow('student_user_id');
}

function username_exists($param)
{
    $db = \Config\Database::connect();
    $sql = "SELECT user_name FROM account_user WHERE user_status < 9 AND user_name = '$param'";

    return $db->query($sql)->getNumRows();
}


