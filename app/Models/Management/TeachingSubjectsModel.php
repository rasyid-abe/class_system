<?php

namespace App\Models\Management;

use CodeIgniter\Model;

class TeachingSubjectsModel extends Model
{
    protected $table      = 'manage_teaching_subjects';
    protected $primaryKey = 'teaching_subjects_id';
    protected $allowedFields = [
        'teaching_subjects_school_id', 
        'teaching_subjects_school_year_id', 
        'teaching_subjects_teacher_id', 
        'teaching_subjects_subject_id', 
        'teaching_subjects_student_group_id', 
        'teaching_subjects_room_id', 
        'teaching_subjects_status', 
        'teaching_subjects_created_by', 
        'teaching_subjects_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'teaching_subjects_created_at';
    protected $updatedField  = 'teaching_subjects_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();
    }

    public function get_teacher_duty($id)
    {
        $query = $this->select('teaching_subjects_id, subject_id, student_group_grade, student_group_name, subject_name, student_group_id')
            ->join('manage_timetable', 'timetable_teaching_subjects_id = teaching_subjects_id')
            ->join('master_student_group', 'student_group_id = timetable_group_id', 'left')
            ->join('master_subject', 'subject_id = teaching_subjects_subject_id', 'left')
            ->where('teaching_subjects_school_id', userdata()['school_id'])
            ->where('teaching_subjects_teacher_id', $id)
            ->where('teaching_subjects_status < 9')
            // ->groupBy('student_group_grade')
            ->orderBy('teaching_subjects_id')
            ->distinct()
            ->findAll();

        return $query;
    }

    public function get_student_lesson($day, $group, $religion)
    {
        $sql = "
            select subject_id, subject_name, teaching_schedule_day, concat(teacher_first_name, ' ',teacher_last_name) teacher_name, teacher_degree, teaching_schedule_time
            from manage_teaching_subjects
            join manage_timetable on teaching_subjects_id = timetable_teaching_subjects_id 
            join master_teaching_schedule on teaching_schedule_id = timetable_teaching_schedule_id 
            join master_subject on subject_id = teaching_subjects_subject_id 
            join profile_teacher on teacher_id = teaching_subjects_teacher_id 
            where teaching_schedule_day = $day
                and teaching_subjects_school_id = ".userdata()['school_id']."
                and teaching_subjects_school_year_id = ".school_year()['id']."
                and timetable_group_id = $group
                and subject_religion in ($religion, 0)
            order by teaching_schedule_order 
        ";

        return $this->db->query($sql)->getResultArray();
    }

}

