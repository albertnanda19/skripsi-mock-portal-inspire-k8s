<?php

namespace App\Repositories;

use App\Models\Role;
use App\Interfaces\RoleRepositoryInterface;
use App\Entities\RoleEntity;
use Config\Database;

class RoleRepository implements RoleRepositoryInterface
{
    protected $roleModel;
    protected $db;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->db = Database::connect();
    }

    public function getRoleById(string $roleId): ?RoleEntity
    {
        $query = $this->db->query("SELECT * FROM roles WHERE role_id = ?", [$roleId]);
        return $query->getFirstRow(RoleEntity::class);
    }

    public function getRoleByName(string $roleName): ?RoleEntity
    {
        $query = $this->db->query("SELECT * FROM roles WHERE role_name = ?", [$roleName]);
        return $query->getFirstRow(RoleEntity::class);
    }
}