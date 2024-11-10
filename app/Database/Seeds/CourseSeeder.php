<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK1071',
                'course_name' => 'PROBABILITAS DAN STATISTIKA'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK1081',
                'course_name' => 'ALGORITMA DAN PEMROGRAMAN KOMPUTER'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK1061',
                'course_name' => 'KALKULUS'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK1042',
                'course_name' => 'ALJABAR LINEAR'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK1052',
                'course_name' => 'METODE NUMERIK'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK2022',
                'course_name' => 'KECERDASAN BUATAN'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK2062',
                'course_name' => 'JARINGAN DAN KOMUNIKASI DATA'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK3012',
                'course_name' => 'BIOINFORMATIKA'
            ],
            [
                'course_id' => $this->generateUuid(),
                'course_code' => 'TIK2042',
                'course_name' => 'PEMODELAN DAN SIMULASI KOMPUTER'
            ]
        ];

        foreach ($courses as $course) {
            $this->db->table('courses')->insert($course);
        }
    }

    private function generateUuid()
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }
}