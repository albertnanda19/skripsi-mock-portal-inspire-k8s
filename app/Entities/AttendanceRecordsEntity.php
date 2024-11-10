<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AttendanceRecordsEntity extends Entity
{
    protected $attributes = [
        'attendance_record_id' => null,
        'attendance_id' => null,
        'user_id' => null,
        'status' => null,
        'timestamp' => null
    ];
}