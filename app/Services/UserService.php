<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getStudentUsers(): array
    {
        return $this->userRepository->getUsersByStudentRole();
    }

    public function getDosenUsers(): array
    {
        return $this->userRepository->getUsersByDosenRole();
    }
}