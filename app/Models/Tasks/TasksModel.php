<?php

namespace App\Models\Tasks;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table      = 'lms_tasks';
    protected $primaryKey = 'task_id';
    protected $allowedFields = [
        'task_school_id', 
        'task_teacher_id', 
        'task_grade', 
        'task_subject_id', 
        // 'task_subject_name', 
        'task_group', 
        'task_title', 
        'task_lesson_id', 
        // 'task_lesson_name', 
        'task_lesson_src', 
        'task_task_ids', 
        'task_start', 
        'task_end', 
        'task_is_autosubmit', 
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
                lms_tasks
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
}

