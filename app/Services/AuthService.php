<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Helpers\JWT;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate($username, $password)
    {
        $user = $this->userRepository->getUserByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            $userClaims = [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'username' => $user->username,
                'role_id' => $user->role_id
            ];
            return JWT::generateTokens($userClaims);
        }
        return null;
    }
}