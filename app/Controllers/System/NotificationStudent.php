<?php

namespace App\Controllers\System;

use App\Controllers\BaseController;
use App\Models\System\ReadNotificationLMSModel;

class NotificationStudent extends BaseController
{
    protected $notification_read;

    public function __construct()
    {
        $this->notification_read = new ReadNotificationLMSModel();
    }

    public function store()
    {
        $req = $this->request->getVar();
        $ids = $req['ids'];
        $type = $req['type'];

        if ($type < 2) {
            $this->notification_read->read_notification($ids);
        } else {
            foreach ($ids as $v) {
                $this->notification_read->read_notification($v);
            }
        }

        echo true;
    } 
}