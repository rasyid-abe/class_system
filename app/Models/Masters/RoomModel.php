<?php

namespace App\Models\Masters;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table      = 'master_room';
    protected $primaryKey = 'room_id';
    protected $allowedFields = [
        'room_school_id', 
        'room_name', 
        'room_capacity', 
        'room_description', 
        'room_status', 
        'room_created_by', 
        'room_updated_by', 
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'room_created_at';
    protected $updatedField  = 'room_updated_at';

    public function getSingle($where = [])
    {
        if (count($where) < 1) {
            return $this->findAll();
        }

        return $this->where($where)->first();

    }
}

