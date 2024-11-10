<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CourseEntity extends Entity
{
    protected $attributes = [
        'course_id' => null,
        'course_code' => null,
        'course_name' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}