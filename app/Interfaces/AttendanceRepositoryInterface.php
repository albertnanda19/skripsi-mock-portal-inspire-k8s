<?php

namespace App\Interfaces;

use App\Entities\AttendanceEntity;

interface AttendanceRepositoryInterface
{
    public function addAttendanceCode(AttendanceEntity $attendance): bool;
    public function getAttendanceByCourseAndSession(string $courseId, int $sessionNumber): ?AttendanceEntity;
}