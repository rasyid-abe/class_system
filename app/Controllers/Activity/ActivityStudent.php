<?php

namespace App\Controllers\Activity;

use App\Controllers\BaseController;
use App\Models\Activities\ActivityModel;
use Faker\Provider\Lorem;

class ActivityStudent extends BaseController
{
    protected $activity;
    protected $title;
    public function __construct()
    {
        $this->title = "Aktivitas Saya";
        $this->activity = new ActivityModel();
    }

    public function index()
    {
       $data = array();
        $data["title"] = 'Aktivitas Saya';
        $data["page"] = 'Dashboard';
        $data["sidebar"] = 'Dashboard';
        $data["breadcrumb"] = [
            '#' => $this->title,
        ];

        $data['days'] = implode(',', get_list('days'));

        return view("activity/student", $data);
    } 

    public function get_data() 
    {
        $rows = $this->activity
            ->where('activity_platform', 'LMS')
            ->where('activity_user_id', userdata()['id'])
            ->orderBy('activity_timestamp', 'desc')
            ->findAll();

        $data = [];
        foreach ($rows as $k => $v) {
            $lists = '
                <div class="row bigrow-tabulator">
                    <div class="col-lg-12 mx-auto">
                            <div class="d-flex align-items-start">
                                <badge class="badge badge-primary">' . datetime_indo($v['activity_timestamp']) . '</badge>
                                <badge class="badge badge-info mx-2">'.$v['activity_log'].'</badge>
                            </div>
                            <span class="text-gray-800 fw-bold">' . $v['activity_desc'] . '.</span>
                    </div>
                </div>
            ';

            $data[] = [
                'id' => $v['activity_id'],
                'lists' => $lists,
            ];
        }

        echo (json_encode($data));
    }
   
}
