<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RoleEntity extends Entity
{
    protected $attributes = [
        'role_id' => null,
        'role_name' => null,
        'created_at' => null,
        'updated_at' => null
    ];
}