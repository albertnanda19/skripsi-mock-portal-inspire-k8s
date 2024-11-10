<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class GradesEntity extends Entity
{
    protected $attributes = [
        'grade_id' => null,
        'enrollment_id' => null,
        'course_id' => null,
        'lecturer_id' => null,
        'grade_value' => null,
        'is_final' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}