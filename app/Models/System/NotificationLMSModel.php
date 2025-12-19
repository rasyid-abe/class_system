<?php

namespace App\Models\System;

use CodeIgniter\Model;

class NotificationLMSModel extends Model
{
    protected $table      = 'sys_notification_lms';
    protected $primaryKey = 'notification_lms_id';
    protected $allowedFields = [
        'notification_lms_school_id', 
        'notification_lms_source_type', 
        'notification_lms_source_id', 
        'notification_lms_title', 
        'notification_lms_message', 
        'notification_lms_group_id', 
        'notification_lms_student_id', 
        'notification_lms_created_by', 
        'notification_lms_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'notification_lms_created_at';
    protected $updatedField  = 'notification_lms_updated_at';

    public function store_notification($type, $type_id, $title, $message, $group = null)
    {
        $data = [
            'notification_lms_school_id' => userdata()['school_id'],
            'notification_lms_source_type' => $type,
            'notification_lms_source_id' => $type_id,
            'notification_lms_title' => $title,
            'notification_lms_message' => $message,
            'notification_lms_group_id' => $group,
        ];
        
        $this->upsert($data);
    }

    public function store_notification_check($type, $type_id, $title, $message, $student_id = null)
    {
        $data = [
            'notification_lms_school_id' => userdata()['school_id'],
            'notification_lms_source_type' => $type,
            'notification_lms_source_id' => $type_id,
            'notification_lms_title' => $title,
            'notification_lms_message' => $message,
            'notification_lms_student_id' => $student_id,
        ];
        
        $this->upsert($data);
    }
}