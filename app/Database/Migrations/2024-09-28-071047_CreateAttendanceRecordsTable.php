<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceRecordsTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE attendance_records (
                attendance_record_id CHAR(36) PRIMARY KEY,
                attendance_id CHAR(36),
                user_id CHAR(36),
                status ENUM('present', 'absent') NOT NULL,
                timestamp TIMESTAMP,
                FOREIGN KEY (attendance_id) REFERENCES attendances(attendance_id),
                FOREIGN KEY (user_id) REFERENCES users(user_id)
            );
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE IF EXISTS attendance_records");
    }
}