<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE enrollments (
                enrollment_id CHAR(36) PRIMARY KEY,
                user_id CHAR(36),
                course_id CHAR(36),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(user_id),
                FOREIGN KEY (course_id) REFERENCES courses(course_id)
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS enrollments");
    }
}