<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EnrollmentsSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua kursus
        $courses = $this->db->table('courses')->get()->getResult();

        // Ambil semua mahasiswa
        $students = $this->db->table('users')
                             ->join('roles', 'roles.role_id = users.role_id')
                             ->where('roles.role_name', 'mahasiswa')
                             ->get()->getResult();

        // Pastikan ada cukup mahasiswa
        if (count($students) < 25) {
            throw new \Exception("Not enough students to assign to courses.");
        }

        foreach ($courses as $course) {
            // Tentukan jumlah mahasiswa secara acak antara 20 dan 25
            $studentCount = rand(20, 25);
            // Pilih mahasiswa secara acak
            $selectedStudentIndexes = array_rand($students, $studentCount);

            foreach ($selectedStudentIndexes as $index) {
                $this->db->table('enrollments')->insert([
                    'enrollment_id' => $this->generateUuid(),
                    'user_id' => $students[$index]->user_id,
                    'course_id' => $course->course_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    private function generateUuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
}