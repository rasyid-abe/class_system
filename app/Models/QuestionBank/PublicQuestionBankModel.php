<?php

namespace App\Models\QuestionBank;

use CodeIgniter\Model;

class PublicQuestionBankModel extends Model
{
    public function get_shared($teacher_id, $subject_id, $grade) 
    {
        $t_id = '"'. $teacher_id .'"';
        $or_subject = count($subject_id) < 1 ? -1 : implode(",",$subject_id);
        $or_grade = count($grade) < 0 ? -1 : implode("','",$grade);

        $query = "
            SELECT
                ms.subject_name, pt.teacher_first_name, pt.teacher_last_name, pt.teacher_degree, lla.question_bank_title as text, lla.*
            FROM
                lms_question_bank lla
            LEFT JOIN 
                master_subject ms ON ms.subject_id = lla.question_bank_subject_id
            LEFT JOIN 
                profile_teacher pt ON pt.teacher_id = lla.question_bank_teacher_id
            WHERE
                lla.question_bank_teacher_id <> ".$teacher_id."
                and
                lla.question_bank_status < 9 
                and 
                (
                    (lla.question_bank_shared_type = 4 and JSON_CONTAINS(lla.question_bank_shared_to, '".$t_id."'))
                    or
                    (lla.question_bank_shared_type = 3 and lla.question_bank_subject_id in ('".$or_subject."') and lla.question_bank_grade in ('".$or_grade."'))
                    or
                    (lla.question_bank_shared_type = 2 and lla.question_bank_subject_id in ('".$or_subject."'))
                    or	
                    lla.question_bank_shared_type = 1
                )
        ";

        return $this->db->query($query)->getResultArray();
    }
}

