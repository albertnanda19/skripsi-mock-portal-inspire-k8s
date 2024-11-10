<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AttendanceEntity extends Entity
{
    protected $attributes = [
        'attendance_id' => null,
        'course_id' => null,
        'session_number' => null,
        'code' => null,
        'deadline' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}