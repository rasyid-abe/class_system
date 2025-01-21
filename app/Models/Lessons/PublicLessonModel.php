<?php

namespace App\Models\Lessons;

use CodeIgniter\Model;

class PublicLessonModel extends Model
{
    public function get_shared($teacher_id, $subject_id, $grade) 
    {
        $t_id = '"'. $teacher_id .'"';
        $or_subject = count($subject_id) < 1 ? -1 : implode(",",$subject_id);
        $or_grade = count($grade) < 0 ? -1 : implode("','",$grade);

        $query = "
            SELECT
                ms.subject_name, pt.teacher_id, pt.teacher_first_name, pt.teacher_last_name, pt.teacher_degree, lla.lesson_additional_chapter as text, lla.*
            FROM
                lms_lesson_additional lla
            LEFT JOIN 
                master_subject ms ON ms.subject_id = lla.lesson_additional_subject_id
            LEFT JOIN 
                profile_teacher pt ON pt.teacher_id = lla.lesson_additional_teacher_id
            WHERE
                lla.lesson_additional_teacher_id <> ".$teacher_id."
                and
                lla.lesson_additional_status < 9 
                and 
                (
                    (lla.lesson_additional_shared_type = 4 and JSON_CONTAINS(lla.lesson_additional_shared_to, '".$t_id."'))
                    or
                    (lla.lesson_additional_shared_type = 3 and lla.lesson_additional_subject_id in ('".$or_subject."') and lla.lesson_additional_grade in ('".$or_grade."'))
                    or
                    (lla.lesson_additional_shared_type = 2 and lla.lesson_additional_subject_id in ('".$or_subject."'))
                    or	
                    lla.lesson_additional_shared_type = 1
                )
        ";

        return $this->db->query($query)->getResultArray();
    }

    public function get_shared_list($teacher_id, $subject_id, $grade)
    {
        $t_id = '"'. $teacher_id .'"';
        $or_subject = count($subject_id) < 1 ? -1 : implode(",",$subject_id);
        $or_grade = count($grade) < 0 ? -1 : implode("','",$grade);

        $query = "
            SELECT
                ms.subject_name, pt.teacher_id, pt.teacher_first_name, pt.teacher_last_name, pt.teacher_degree, lla.lesson_additional_chapter as text, lla.*
            FROM
                lms_lesson_additional lla
            LEFT JOIN 
                master_subject ms ON ms.subject_id = lla.lesson_additional_subject_id
            LEFT JOIN 
                profile_teacher pt ON pt.teacher_id = lla.lesson_additional_teacher_id
            WHERE
                lla.lesson_additional_teacher_id <> ".$teacher_id."
                and
                lla.lesson_additional_subject_id = ".$subject_id[0]."
                and
                lla.lesson_additional_status < 9 
                and 
                (
                    (lla.lesson_additional_shared_type = 4 and JSON_CONTAINS(lla.lesson_additional_shared_to, '".$t_id."'))
                    or
                    (lla.lesson_additional_shared_type = 3 and lla.lesson_additional_subject_id in ('".$or_subject."') and lla.lesson_additional_grade in ('".$or_grade."'))
                    or
                    (lla.lesson_additional_shared_type = 2 and lla.lesson_additional_subject_id in ('".$or_subject."'))
                    or	
                    lla.lesson_additional_shared_type = 1
                )
        ";

        return $this->db->query($query)->getResultArray();
    }
}

