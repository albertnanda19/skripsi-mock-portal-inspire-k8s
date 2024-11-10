<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    protected $attributes = [
        'user_id' => null,
        'name' => null,
        'username' => null,
        'password' => null,
        'email' => null,
        'role_id' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null
    ];
}