<?php

namespace App\Entities;

class JWTEntity
{
    public $userId;
    public $name;
    public $username;
    public $roleId;
    public $tokenType;

    public function __construct(array $data)
    {
        $this->userId = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->roleId = $data['role_id'] ?? null;
        $this->tokenType = $data['token_type'] ?? null;
    }

    public static function fromAccessToken($token)
    {
        $decoded = \App\Helpers\JWT::decodeAccessToken($token);
        if ($decoded) {
            return new self($decoded);
        }
        return null;
    }

    public static function fromRefreshToken($token)
    {
        $decoded = \App\Helpers\JWT::decodeRefreshToken($token);
        if ($decoded) {
            return new self($decoded);
        }
        return null;
    }
}