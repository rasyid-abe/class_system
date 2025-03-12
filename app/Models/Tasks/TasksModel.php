<?php

namespace App\Models\Tasks;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table      = 'lms_task';
    protected $primaryKey = 'task_id';
    protected $allowedFields = [
        'task_school_id', 
        'task_teacher_id', 
        'task_grade', 
        'task_subject_id', 
        'task_group', 
        'task_title', 
        'task_lesson_id', 
        'task_lesson_src', 
        'task_task_ids', 
        'task_start', 
        'task_end', 
        'task_is_autosubmit', 
        'task_religion', 
        'task_instruction',
        'task_status', 
        'task_created_by', 
        'task_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'task_created_at';
    protected $updatedField  = 'task_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

    public function get_list_student_task($type)
    {
        $add_where = "AND ";
        $add_join = "";
        if ($type == 1) {
            $add_join .= "left join lms_task_result on task_id = task_result_task_id AND task_result_student_id = " . userdata()['id_profile'];
            $add_where .= "task_status = 2 AND task_start <= '" . date('Y-m-d H:i:s') . "' AND task_end > '" . date('Y-m-d H:i:s') ."' AND task_result_submit_datetime is null ";
        } elseif ($type == 2) {
            $add_where .= "task_status = 2 AND task_end < '" . date('Y-m-d H:i:s') . "'";
        } elseif ($type == 3) {
            $add_join .= "left join lms_task_result on task_id = task_result_task_id";
            $add_where .= "task_status = 2 AND task_result_student_id = ". userdata()['id_profile'] ." AND task_result_submit_datetime is not null ";
        }

        $my_group = student_group();
        $sql = "
            SELECT
                task_id,
                task_title,
                task_start,
                task_end,
                task_grade,
                task_subject_id,
                task_group,
                task_lesson_id,
                task_lesson_src,
                task_task_ids,
                task_religion,
                subject_name,
                lesson_additional_chapter,
                lesson_additional_subchapter,
                lesson_standart_chapter,
                lesson_standart_subchapter,
                teacher_first_name,
                teacher_last_name,
                teacher_degree
            FROM
                lms_task
            LEFT JOIN profile_teacher ON teacher_id=task_teacher_id
            LEFT JOIN master_subject ON subject_id=task_subject_id
            LEFT JOIN lms_lesson_additional ON lesson_additional_id=task_lesson_id
            LEFT JOIN lms_lesson_standart ON lesson_standart_id=task_lesson_id
            $add_join
            WHERE 1=1 
                $add_where
                AND task_school_id = ".userdata()['school_id']."
                AND task_group LIKE '%".$my_group['group_name']."%'
            GROUP BY task_id";

        return $this->db->query($sql)->getResultArray();
    }

    public function get_list_task($type)
    {
        $my_group = student_group();
        
        $add_where = "AND ";
        if ($type == 1) {
            $add_where .= "task_status = 2 AND task_start <= '" . date('Y-m-d H:i:s') . "' AND task_end >= '" . date('Y-m-d H:i:s') ."'";
        } elseif ($type == 2) {
            $add_where .= "task_status = 2 AND task_end < '" . date('Y-m-d H:i:s') . "'";
        } elseif ($type == 3) {
            $add_where .= "task_status = 2 AND task_end < '" . date('Y-m-d H:i:s') . "'";
        }

        $sql = "
            SELECT
                task_id,
                task_group,
                task_grade,
                task_title,
                task_start,
                task_end,
                task_lesson_id,
                task_lesson_src,
                task_task_ids,
                task_subject_id,
                subject_name,
                lesson_additional_chapter,
                lesson_additional_subchapter,
                lesson_standart_chapter,
                lesson_standart_subchapter,
                teacher_first_name,
                teacher_last_name,
                teacher_degree
            FROM
                lms_task
            LEFT JOIN master_subject ON subject_id=task_subject_id
            LEFT JOIN lms_lesson_additional ON lesson_additional_id=task_lesson_id
            LEFT JOIN lms_lesson_standart ON lesson_standart_id=task_lesson_id
            LEFT JOIN profile_teacher ON teacher_id=task_teacher_id
            WHERE 1=1
                $add_where
                AND task_school_id = ".userdata()['school_id']."
                AND task_group LIKE '%".$my_group['group_name']."%'
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function data_draft($select, $school_id, $teacher_id, $date_now)
    {
        $sql = "
            select 
                $select
            from lms_task
            LEFT JOIN master_subject ON subject_id = task_subject_id
            left join lms_lesson_additional on task_lesson_id = lesson_additional_id
            left join lms_lesson_standart on task_lesson_id = lesson_standart_id
            where 
                task_status = 1
                and task_school_id = $school_id
                and task_teacher_id = $teacher_id
            order by
                task_id asc
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function data_scheduled($select, $school_id, $teacher_id, $date_now)
    {
        $sql = "
            select 
                $select
            from lms_task
            LEFT JOIN master_subject ON subject_id = task_subject_id
            left join lms_lesson_additional on task_lesson_id = lesson_additional_id
            left join lms_lesson_standart on task_lesson_id = lesson_standart_id
            where 
                task_status = 2
                and task_school_id = $school_id
                and task_teacher_id = $teacher_id
                and task_start >= '$date_now'
            order by
                task_id asc
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function data_present($select, $school_id, $teacher_id, $date_now)
    {
        $sql = "
            select 
                $select
            from lms_task
            LEFT JOIN master_subject ON subject_id = task_subject_id
            left join lms_lesson_additional on task_lesson_id = lesson_additional_id
            left join lms_lesson_standart on task_lesson_id = lesson_standart_id
            where 
                task_status = 2
                and task_school_id = $school_id
                and task_teacher_id = $teacher_id
                and task_start <= '$date_now' 
                and task_end >= '$date_now'
            order by
                task_id asc
        ";

        return $this->db->query($sql)->getResultArray();
    }

    public function data_done($select, $school_id, $teacher_id, $date_now)
    {
        $sql = "
            select 
                $select
            from lms_task
            LEFT JOIN master_subject ON subject_id = task_subject_id
            left join lms_lesson_additional on task_lesson_id = lesson_additional_id
            left join lms_lesson_standart on task_lesson_id = lesson_standart_id
            where 
                task_status = 2
                and task_school_id = $school_id
                and task_teacher_id = $teacher_id
                and task_end <= '$date_now'
            order by
                task_id asc
        ";

        return $this->db->query($sql)->getResultArray();
    }
}

