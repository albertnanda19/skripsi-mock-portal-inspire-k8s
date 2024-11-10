<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EnrollmentEntity extends Entity
{
    protected $attributes = [
        'enrollment_id' => null,
        'user_id' => null,
        'course_id' => null,
        'created_at' => null
    ];
}