<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGradesTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE grades (
                grade_id CHAR(36) PRIMARY KEY,
                enrollment_id CHAR(36),
                course_id CHAR(36),
                lecturer_id CHAR(36),
                grade_value FLOAT,
                is_final BOOLEAN NOT NULL DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (enrollment_id) REFERENCES enrollments(enrollment_id),
                FOREIGN KEY (course_id) REFERENCES courses(course_id),
                FOREIGN KEY (lecturer_id) REFERENCES users(user_id)
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS grades");
    }
}