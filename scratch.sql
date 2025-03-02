ALTER TABLE account_user CHANGE user_id user_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_access CHANGE access_id access_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_active_year CHANGE active_year_id active_year_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_menu CHANGE menu_id menu_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_menu_shortcut CHANGE menu_shortcut_id menu_shortcut_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_role CHANGE role_id role_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE account_token CHANGE token_id token_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_assessment CHANGE assessment_id assessment_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_lesson_additional CHANGE lesson_additional_id lesson_additional_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_lesson_school CHANGE lesson_school_id lesson_school_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_lesson_standart CHANGE lesson_standart_id lesson_standart_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_question_bank CHANGE question_bank_id question_bank_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_question_bank_standart CHANGE question_bank_standart_id question_bank_standart_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_student_assignment CHANGE student_assignment_id student_assignment_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE lms_tasks CHANGE task_id task_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_exam_schedule CHANGE exam_schedule_id exam_schedule_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_major CHANGE major_id major_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_room CHANGE room_id room_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_school_year CHANGE school_year_id school_year_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_student_group CHANGE student_group_id student_group_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_subject CHANGE subject_id subject_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE master_teaching_schedule CHANGE teaching_schedule_id teaching_schedule_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE profile_school CHANGE school_id school_id int AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE profile_teacher CHANGE teacher_id teacher_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE profile_student CHANGE student_id student_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE system_student_in_group CHANGE student_in_group_id student_in_group_id bigint AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE system_teacher_assign CHANGE teacher_assign_id teacher_assign_id bigint AUTO_INCREMENT PRIMARY KEY;

-- u473302199_school_system.lms_assessment_result definition

CREATE TABLE `lms_assessment_result` (
  `assessment_result_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `assessment_result_assessment_id` bigint(20) NOT NULL,
  `assessment_result_school_id` int(11) NOT NULL,
  `assessment_result_student_in_group_id` bigint(20) NOT NULL,
  `assessment_result_student_id` bigint(20) NOT NULL,
  `assessment_result_begin_assignment_datetime` datetime DEFAULT NULL,
  `assessment_result_submit_datetime` datetime DEFAULT NULL,
  `assessment_result_end_datetime` datetime DEFAULT NULL,
  `assessment_result_answer` mediumtext DEFAULT NULL,
  `assessment_result_value` tinyint(4) DEFAULT NULL,
  `assessment_result_fault` tinyint(4) DEFAULT NULL,
  `assessment_result_submit_message` text DEFAULT NULL,
  PRIMARY KEY (`assessment_result_id`)
) ENGINE=InnoDB AUTO_INCREMENT=467 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `account_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_role_id` int(11) NOT NULL,
  `access_menu_id` int(11) NOT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


ALTER TABLE `lms_assessment` ADD `assessment_religion` TINYINT(2) NOT NULL AFTER `assessment_duration`;

ALTER TABLE `lms_assessment_result` ADD `assessment_jresult_created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `assessment_result_submit_message`;