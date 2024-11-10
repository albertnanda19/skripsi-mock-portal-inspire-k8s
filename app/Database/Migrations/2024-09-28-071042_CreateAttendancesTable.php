<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE attendances (
                attendance_id CHAR(36) PRIMARY KEY,
                course_id CHAR(36),
                session_number INT NOT NULL,
                code VARCHAR(50) NOT NULL,
                deadline TIMESTAMP,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (course_id) REFERENCES courses(course_id)
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS attendances");
    }
}