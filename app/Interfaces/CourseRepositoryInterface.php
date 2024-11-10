<?php

namespace App\Interfaces;

use App\Entities\CourseEntity;

interface CourseRepositoryInterface
{
    public function getAllCourses(): array;
    public function getCourseById(string $courseId): ?CourseEntity;
    public function getCourseByLecturerAndCourseId(string $userId, string $courseId): ?CourseEntity;
}