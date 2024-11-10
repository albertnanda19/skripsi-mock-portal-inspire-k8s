<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterface;
use App\Entities\CourseEntity;
use Config\Database;

class CourseRepository implements CourseRepositoryInterface
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllCourses(): array
    {
        $query = $this->db->query("SELECT course_id, course_code, course_name FROM courses");
        return $query->getResult(CourseEntity::class);
    }

    public function getCourseById(string $courseId): ?CourseEntity
    {
        $query = $this->db->query("SELECT * FROM courses WHERE course_id = ?", [$courseId]);
        $result = $query->getResult(CourseEntity::class);
        return count($result) > 0 ? $result[0] : null;
    }

    public function getCourseByLecturerAndCourseId(string $userId, string $courseId): ?CourseEntity
    {
        $sql = "SELECT c.* FROM courses c
                JOIN course_lecturers cl ON c.course_id = cl.course_id
                WHERE cl.user_id = ? AND c.course_id = ?";
        $query = $this->db->query($sql, [$userId, $courseId]);
        $result = $query->getResult(CourseEntity::class);
        return count($result) > 0 ? $result[0] : null;
    }
}