<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CourseService;
use App\Repositories\CourseRepository; 
use App\Helpers\Response;

class CourseController extends BaseController
{
    protected $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService(new CourseRepository());
    }

    public function index()
    {
        $courses = $this->courseService->getAllCourses();
        $formattedCourses = array_map(function ($course) {
            return [
                'id' => $course->course_id,
                'name' => $course->course_name,
                'code' => $course->course_code
            ];
        }, $courses);

        return Response::send(200, 'Berhasil mengambil daftar mata kuliah', $formattedCourses);
    }
}