<?php

namespace App\Models\Activities;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class ActivityModel extends Model
{
    protected $table      = 'account_activity';
    protected $primaryKey = 'activity_id';
    protected $allowedFields = [
        'activity_user_id', 
        'activity_role_id', 
        'activity_platform', 
        'activity_page', 
        'activity_log', 
        'activity_desc'
    ];

    protected $useAutoIncrement = false; // penting

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }

    public function store_log($page, $log, $desc)
    {
        $data = [
            'activity_id' => Uuid::uuid4()->toString(),
            'activity_user_id' => session()->get('c_id'),
            'activity_platform' => 'lms',
            'activity_page' => $page,
            'activity_log' => $log,
            'activity_desc' => $desc
        ];
        
        $this->save($data);
    }
}

