<?php

namespace App\Interfaces;

use App\Entities\UserEntity;

interface UserRepositoryInterface
{    
    public function getUserByUsername(string $username): ?UserEntity;  
    public function getUsersByRole(string $roleId): array;
    public function getUserByName(string $name): ?array;
    public function getUsersByStudentRole(): array; 
    public function getUsersByDosenRole(): array;
}