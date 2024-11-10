<?php

namespace App\Services;

use App\Interfaces\AttendanceRepositoryInterface;
use App\Interfaces\CourseRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Entities\AttendanceEntity;

class AttendanceService
{
    protected $attendanceRepository;
    protected $courseRepository;
    protected $roleRepository;

    public function __construct(
        AttendanceRepositoryInterface $attendanceRepository,
        CourseRepositoryInterface $courseRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->attendanceRepository = $attendanceRepository;
        $this->courseRepository = $courseRepository;
        $this->roleRepository = $roleRepository;
    }

    public function createAttendanceCode(string $courseId, int $sessionNumber, string $deadline, string $roleId, string $userId): ?string
    {
        $role = $this->roleRepository->getRoleById($roleId);
        if (!$role) {
            throw new \Exception("Role ID tidak valid.");
        }

        if ($role->role_name === 'mahasiswa') {
            throw new \Exception("Mahasiswa tidak diizinkan untuk mengenerate kode presensi.", 409);
        }

        // Validate if the user is the lecturer of the course
        $course = $this->courseRepository->getCourseByLecturerAndCourseId($userId, $courseId);
        if (!$course) {
            throw new \Exception("User tidak terdaftar sebagai dosen untuk mata kuliah ini.");
        }

        $existingAttendance = $this->attendanceRepository->getAttendanceByCourseAndSession($courseId, $sessionNumber);
        if ($existingAttendance) {
            throw new \Exception("Presensi untuk kursus dan sesi ini sudah ada.");
        }
        
        $code = $this->generateAttendanceCode();
        $uuid = $this->generateUUID();

        $attendance = new AttendanceEntity([
            'attendance_id' => $uuid,
            'course_id' => $courseId,
            'session_number' => $sessionNumber,
            'code' => $code,
            'deadline' => $deadline
        ]);

        $success = $this->attendanceRepository->addAttendanceCode($attendance);

        if ($success) {
            return $code;
        } else {
            throw new \Exception("Gagal mengenerate kode presensi.");
        }
    }

    protected function generateAttendanceCode(): string
    {
        $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        $numbers = substr(str_shuffle("0123456789"), 0, 2);
        $code = str_shuffle($letters . $numbers);
        return $code;
    }

    protected function generateUUID(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}