<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Response;
use App\Repositories\UserRepository;
use App\Services\UserService;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService(new UserRepository());
    }

    public function index()
    {
        //
    }

    public function students()
    {
        $students = $this->userService->getStudentUsers();
        return Response::send(200, 'Success', $students);
    }

    public function teachers()
    {
        $teachers = $this->userService->getDosenUsers();
        return Response::send(200, 'Success', $teachers);
    }
}