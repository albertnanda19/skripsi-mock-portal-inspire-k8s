<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CourseLectureEntity extends Entity
{
    protected $attributes = [
        'course_lecturer_id' => null,
        'course_id' => null,
        'user_id' => null,
        'is_primary' => null
    ];
}