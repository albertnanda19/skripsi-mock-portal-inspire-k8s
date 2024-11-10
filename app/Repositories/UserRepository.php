<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Entities\UserEntity;

class UserRepository implements UserRepositoryInterface 
{
    protected $userModel;
    protected $db;
    public function __construct()
    {
        $this->userModel = new User();
        $this->db = \Config\Database::connect();
    }

    
    public function getUserByUsername(string $username): ?UserEntity
    {
        $query = $this->db->query("SELECT * FROM users WHERE username = ?", [$username]);
        return $query->getFirstRow(UserEntity::class);
    }

    
    public function getUsersByRole(string $roleId): array
    {
        $query = $this->db->query("SELECT * FROM users WHERE role_id = ?", [$roleId]);
        return $query->getResultArray();
    }

    
    public function getUserByName(string $name): ?array
    {
        $query = $this->db->query("SELECT * FROM users WHERE name = ?", [$name]);
        return $query->getResultArray();
    }

    public function getUsersByStudentRole(): array
    {
        $query = $this->db->query("SELECT u.user_id, u.name, u.username FROM users u JOIN roles r ON u.role_id = r.role_id WHERE r.role_name = 'mahasiswa'");
        return $query->getResult(UserEntity::class); 
    }

    public function getUsersByDosenRole(): array
    {
        $query = $this->db->query("SELECT u.user_id, u.name, u.username FROM users u JOIN roles r ON u.role_id = r.role_id WHERE r.role_name = 'dosen'");
        return $query->getResult(UserEntity::class); 
    }
}