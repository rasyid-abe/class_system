<?php
use Aws\S3\S3Client;
use Dotenv\Dotenv;

function userdata()
{
    $db = \Config\Database::connect();

    $user = session()->get('c_id');
    $role = session()->get('c_role');

    if ($role == 11) {
        $select = "
            au.user_id,
            au.user_name,
            pt.teacher_school_id school_id,
            pt.teacher_id id_profile,
            pt.teacher_religion religi,
            CONCAT(pt.teacher_first_name, ' ', pt.teacher_last_name) name,
            pt.teacher_degree degree,
            pt.teacher_image image,
            pt.teacher_nip,
            pt.teacher_nuptk,
            ar.role_name
        ";
        $join = "LEFT JOIN profile_teacher pt ON au.user_id = pt.teacher_user_id";
        $user_role = 'teacher';
    } else if ($role == 12) {
        $select = "
            au.user_id,
            au.user_name,
            ps.student_school_id school_id,
            ps.student_id id_profile,
            ps.student_religion religi,
            CONCAT(ps.student_first_name, ' ', ps.student_last_name) name,
            ps.student_image image,
            ps.student_nisn,
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

function list_grade($id) 
{
    return get_list('grade')[school_level($id)];
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

function teacher_grades($id)
{
    $db = \Config\Database::connect();
    // $sql = "SELECT DISTINCT teacher_assign_grade FROM manage_teacher_assign WHERE teacher_assign_teacher_id = '$id' AND teacher_assign_status < 9";
    $sql = "
        select distinct student_group_grade
        from manage_teaching_subjects
        left join manage_timetable on timetable_teaching_subjects_id = teaching_subjects_id
        left join master_student_group on student_group_id = timetable_group_id
        where teaching_subjects_teacher_id = $id and teaching_subjects_status < 9 
        and teaching_subjects_school_id = ".userdata()['school_id']." and teaching_subjects_school_year_id = ".school_year()['id']."
    ";

    $result = $db->query($sql)->getResultArray();
    return array_column($result, 'student_group_grade');
}

function teacher_subjects($id)
{
    $db = \Config\Database::connect();
    // $sql = "SELECT DISTINCT teacher_assign_subject_id FROM manage_teacher_assign WHERE teacher_assign_teacher_id = '$id' AND teacher_assign_status < 9";
    $sql = "
        select distinct teaching_subjects_subject_id from manage_teaching_subjects where teaching_subjects_teacher_id = $id and teaching_subjects_status < 9
        and teaching_subjects_school_id = ".userdata()['school_id']." and teaching_subjects_school_year_id = ".school_year()['id']."
    ";

    $result = $db->query($sql)->getResultArray();
    return array_column($result, 'teaching_subjects_subject_id');
}

function random_char($length = 10) 
{
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

function year_active()
{
    $db = \Config\Database::connect();

    $user = session()->get('c_id');
    
    $sql = "
        SELECT b.school_year_period, b.school_year_id
        FROM account_active_year a
        LEFT JOIN master_school_year b ON b.school_year_id = a.active_year_school_year_id
        WHERE b.school_year_status < 9 AND a.active_year_user_id = $user
    ";

    $row = $db->query($sql)->getRowArray();
    return $row;
}

function distinct_array($arr, $val)
{
    $tempArray = array_unique(array_column($arr, $val));
    $moreUniqueArray = array_values(array_intersect_key($arr, $tempArray));
    return $moreUniqueArray;
}

function subject_rowid($id) 
{
    $db = \Config\Database::connect();
    
    $sql = "
        SELECT *
        FROM master_subject ms
        WHERE ms.subject_id = $id
    ";

    $row = $db->query($sql)->getRowArray();
    return $row;
}

if (!function_exists("student_religion")) {
    function student_religion($id) 
    {
        $db = \Config\Database::connect();
        
        $sql = "
            select student_religion
            from profile_student where student_id = $id
        ";

        $row = $db->query($sql)->getRowArray();
     
        return $row['student_religion'];
    }
}

if (!function_exists("my_groups")) {
    function my_groups() 
    {
        $db = \Config\Database::connect();
        
        if (isset(school_year()['id'])) {
            $sql = "
                select distinct student_group_id, student_group_name
                from manage_teaching_subjects
                join manage_timetable on timetable_teaching_subjects_id = teaching_subjects_id
                left join master_student_group on student_group_id = timetable_group_id
                where teaching_subjects_teacher_id = ".userdata()['id_profile']." and teaching_subjects_status < 9
                and teaching_subjects_school_id = ".userdata()['school_id']." and teaching_subjects_school_year_id = ".school_year()['id']."
                order by student_group_name
            ";
    
            $row = $db->query($sql)->getResultArray();
        } else {
            $row = [];
        }
     
        return $row;
    }
}

if (!function_exists("school_year")) {
    function school_year() {
        $now = date('Y-m-d');
        $role = session()->get('role');

        $db = \Config\Database::connect();

        $filter_school = '';
        if ($role > 2) {
            $filter_school = "and school_year_school_id = ".userdata()['school_id'];
        }

        if ($role < 4) {
            $sql = "
                select
                    school_year_id as id, school_year_period as period
                from
                    master_school_year
                where '$now' < school_year_end_date_two $filter_school
                order by master_school_year.school_year_start_date_one asc
                limit 1
            ";
        } else {
            $sql = "
                SELECT 
                    school_year_id as id, school_year_period as period
                FROM master_school_year 
                WHERE '$now' >= CAST(DATE_FORMAT(school_year_start_date_one ,'%Y-%m-01') as DATE) 
                    AND '$now' <= CAST(DATE_FORMAT(school_year_end_date_two ,'%Y-%m-31') as DATE)
                    AND school_year_school_id = " . userdata()['school_id'];

        }
        
        return $db->query($sql)->getRowArray();
    }
}

if (!function_exists("datetime_indo")) {
    function datetime_indo($datetime) 
    {
        $bulan = array (1 => 'Jan',
			'Feb',
			'Mar',
			'Apr',
			'Mei',
			'Jun',
			'Jul',
			'Agu',
			'Sep',
			'Okt',
			'Nov',
			'Des'
		);

        $spl = explode(' ', $datetime);
        $split = explode('-', $spl[0]);
	    return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0] . ' ' . substr($spl[1],0, 5) . ' WIB';

    }
}

if (!function_exists("grade_label")) {
    function grade_label($grade) 
    {
        $label = array (1 => 'Kelas I',
			'Kelas II',
			'Kelas III',
			'Kelas IV',
			'Kelas V',
			'Kelas VI',
			'Kelas VII',
			'Kelas VIII',
			'Kelas IX',
			'Kelas X',
			'Kelas XI',
			'Kelas XII'
		);
	    return $label[$grade];

    }
}

if (!function_exists("student_grade")) {
    function student_grade() 
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT student_in_group_grade as grade
            FROM manage_student_in_group
            WHERE student_in_group_student_id = ".userdata()['id_profile']."
                AND student_in_group_status < 8
        ";

        $row = $db->query($sql)->getRow('grade');
        return $row;
    }
}

if (!function_exists("student_group")) {
    function student_group() 
    {
        $db = \Config\Database::connect();
        $sql = "
            SELECT student_in_group_student_group_id as group_id, student_group_name as group_name, student_in_group_grade as grade
            FROM manage_student_in_group 
            JOIN master_student_group ON student_in_group_student_group_id = student_group_id
            WHERE student_in_group_student_id = ".userdata()['id_profile']."
                AND student_in_group_status < 8
        ";

        $row = $db->query($sql)->getRowArray();
        return $row;
    }
}

if (!function_exists("s3_uploads")) {
    function s3_uploads($file_temp, $file_name, $content_type, $disposition = null) 
    {
        $region = getenv()['S3_BUCKET_REGION'];
        $version = getenv()['S3_BUCKET_VERSION'];
        $access_key_id = getenv()['S3_BUCKET_ACCESS_KEY'];
        $secret_access_key = getenv()['S3_BUCKET_SECRET_KEY'];
        $bucket = getenv()['S3_BUCKET'];

        $res = [];
        $res['status'] = false;

        $file_temp_src = $file_temp;

        if (is_uploaded_file($file_temp_src)) {
            $s3 = new S3Client([
                'version' => $version,
                'region' => $region,
                'credentials' => [
                    'key' => $access_key_id,
                    'secret' => $secret_access_key,
                ]
            ]);

            try {
                $config = [];
                $config['Bucket'] = $bucket;
                $config['Key'] = $file_name;
                $config['SourceFile'] = $file_temp_src;
                $config['ContentType'] = $content_type;
                $config['ACL'] = 'public-read';
                if ($disposition != null) {
                    $config['ContentDisposition'] = $disposition;
                }

                $result = $s3->putObject($config);
                $result_arr = $result->toArray();

                if (!empty($result_arr['ObjectURL'])) {
                    $res['status'] = true;
                    $res['s3_link'] = $result_arr['ObjectURL'];
                    $res['message'] = 'Upload success!';
                } else {
                    $res['message'] = 'Upload Failed! S3 Object URL not found!';
                }
            } catch (Aws\S3\Exception\S3Exception $e) {
                $res['message'] = $e->getMessage();
            }
        } else {
            $res['message'] = 'Invalid temp file';
        }

        return $res;
    }
}

if (!function_exists("s3_unlink")) {
    function s3_unlink($pathfile) 
    {
        $region = getenv()['S3_BUCKET_REGION'];
        $version = getenv()['S3_BUCKET_VERSION'];
        $access_key_id = getenv()['S3_BUCKET_ACCESS_KEY'];
        $secret_access_key = getenv()['S3_BUCKET_SECRET_KEY'];
        $bucket = getenv()['S3_BUCKET'];

        $s3 = new S3Client([
            'version' => $version,
            'region' => $region,
            'credentials' => [
                'key' => $access_key_id,
                'secret' => $secret_access_key,
            ]
        ]);

        $result = $s3->deleteObject(array(
            'Bucket' => $bucket,
            'Key'    => $pathfile
        ));

        return $result->toArray();
    }
}

if (!function_exists("s3_listfile")) {
    function s3_listfile() 
    {
        $region = getenv()['S3_BUCKET_REGION'];
        $version = getenv()['S3_BUCKET_VERSION'];
        $access_key_id = getenv()['S3_BUCKET_ACCESS_KEY'];
        $secret_access_key = getenv()['S3_BUCKET_SECRET_KEY'];
        $bucket = getenv()['S3_BUCKET'];

        $res = [];

        $s3 = new S3Client([
            'version' => $version,
            'region' => $region,
            'credentials' => [
                'key' => $access_key_id,
                'secret' => $secret_access_key,
            ]
        ]);

        $objects = $s3->listObjects([
            "Bucket" => $bucket
        ]);

        return $objects->toArray();
    }
}

if (!function_exists("getenv")) {
    function getenv() 
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        return $_ENV;
    }
}



