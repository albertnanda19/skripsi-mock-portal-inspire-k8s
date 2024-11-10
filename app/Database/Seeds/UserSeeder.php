<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roleIds = $this->db->table('roles')->select('role_id, role_name')->get()->getResult();

        $users = [];
        foreach ($roleIds as $role) {
            $userCount = ($role->role_name === 'mahasiswa') ? 120 : 3; 

            for ($i = 1; $i <= $userCount; $i++) {
                $username = $this->generateUsername($role->role_name, $i);
                $name = $this->generateName($role->role_name, $i); 

                $users[] = [
                    'user_id' => $this->generateUuid(),
                    'name' => $name, 
                    'username' => $username,
                    'password' => password_hash('password', PASSWORD_DEFAULT),
                    'email' => $username . '@example.com',
                    'role_id' => $role->role_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
        }
    }

    private function generateUuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    private function generateUsername($roleName, $index)
    {
        if ($roleName === 'mahasiswa') {
            return '210211060' . str_pad($index, 3, '0', STR_PAD_LEFT);
        } elseif ($roleName === 'dosen') {
            return '19900223201803100' . $index;
        } else {
            return '19900223201804100' . $index;
        }
    }

    private function generateName($roleName, $index)
    {
        
        if ($roleName === 'mahasiswa') {
            return "Student " . $index;
        } elseif ($roleName === 'dosen') {
            return "Lecturer " . $index;
        } else {
            return "Admin " . $index;
        }
    }
}