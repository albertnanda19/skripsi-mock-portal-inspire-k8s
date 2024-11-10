<?php

namespace App\Interfaces;

use App\Entities\RoleEntity;

interface RoleRepositoryInterface
{    
    public function getRoleById(string $roleId): ?RoleEntity;  
    public function getRoleByName(string $roleName): ?RoleEntity;
}