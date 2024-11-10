<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseLecturersTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE course_lecturers (
                course_lecturer_id CHAR(36) PRIMARY KEY,
                course_id CHAR(36),
                user_id CHAR(36),
                is_primary BOOLEAN NOT NULL DEFAULT FALSE,
                FOREIGN KEY (course_id) REFERENCES courses(course_id),
                FOREIGN KEY (user_id) REFERENCES users(user_id)
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS course_lecturers");
    }
}