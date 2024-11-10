<?php

namespace App\Repositories;

use App\Interfaces\AttendanceRepositoryInterface;
use App\Entities\AttendanceEntity;
use Config\Database;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    protected $db;
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function addAttendanceCode(AttendanceEntity $attendance): bool
    {
        $sql = "INSERT INTO attendances (attendance_id, course_id, session_number, code, deadline) VALUES (?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, [
            $attendance->attendance_id,
            $attendance->course_id,
            $attendance->session_number,
            $attendance->code,
            $attendance->deadline
        ]);

        return $query ? true : false;
    }

    /**
     * Retrieves attendance data based on course_id and session_number.
     *
     * @param string $courseId
     * @param int $sessionNumber
     * @return AttendanceEntity|null
     */
    public function getAttendanceByCourseAndSession(string $courseId, int $sessionNumber): ?AttendanceEntity
    {
        $sql = "SELECT * FROM attendances WHERE course_id = ? AND session_number = ?";
        $query = $this->db->query($sql, [$courseId, $sessionNumber]);
        $result = $query->getResult(AttendanceEntity::class);
        return count($result) > 0 ? $result[0] : null;
    }
}