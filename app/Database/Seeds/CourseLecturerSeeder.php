<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseLecturerSeeder extends Seeder
{
    public function run()
    {
        $lecturers = $this->db->table('users')
                              ->join('roles', 'roles.role_id = users.role_id')
                              ->where('roles.role_name', 'dosen')
                              ->get()->getResult();

     
        $courses = $this->db->table('courses')->get()->getResultArray();

     
        if (count($courses) < 3) {
            throw new \Exception("Not enough courses to assign to lecturers.");
        }

     
        foreach ($lecturers as $lecturer) {
            $assignedCourses = array_rand($courses, 3); 

            foreach ($assignedCourses as $index) {
                $this->db->table('course_lecturers')->insert([
                    'course_lecturer_id' => $this->generateUuid(),
                    'course_id' => $courses[$index]['course_id'],
                    'user_id' => $lecturer->user_id,
                    'is_primary' => true 
                ]);
            }
        }
    }

    private function generateUuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
}