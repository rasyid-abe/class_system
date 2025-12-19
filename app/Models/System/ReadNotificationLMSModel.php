<?php

namespace App\Models\System;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ReadNotificationLMSModel extends Model
{
    protected $table      = 'sys_read_notification_lms';
    protected $primaryKey = 'read_notification_lms_id';
    protected $allowedFields = [
        'read_notification_lms_student_id', 
        'read_notification_lms_notification_id', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'read_notification_lms_created_at';
    protected $updatedField  = 'read_notification_lms_updated_at';

    public function read_notification($notif_id)
    {
        $data = [
            'read_notification_lms_id' => Uuid::uuid4()->toString(),
            'read_notification_lms_school_id' => userdata()['school_id'],
            'read_notification_lms_group_id' => student_group()['group_id'],
            'read_notification_lms_student_id' => userdata()['id_profile'],
            'read_notification_lms_notification_id' => $notif_id,
        ];
        
        $this->upsert($data);
    }
}