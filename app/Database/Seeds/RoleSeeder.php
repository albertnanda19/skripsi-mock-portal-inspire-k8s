<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid; 

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_id' => $this->generateUuid(),
                'role_name' => 'mahasiswa'
            ],
            [
                'role_id' => $this->generateUuid(),
                'role_name' => 'dosen'
            ],
            [
                'role_id' => $this->generateUuid(),
                'role_name' => 'admin'
            ]
        ];

        foreach ($data as $row) {
            $this->db->table('roles')->insert($row);
        }
    }

    private function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }
}