<?php

namespace App\Helpers;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\UnencryptedToken;
use Firebase\JWT\JWT as FirebaseJWT; // Menggunakan alias untuk menghindari konflik
use Firebase\JWT\Key;

class JWT
{
    public static function generateTokens(array $user): array
    {
        $config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(ROOTPATH . 'private.key'), 
            InMemory::file(ROOTPATH . 'public.key')
        );

        $now = new \DateTimeImmutable();
        $access_token = $config->builder()
            ->issuedBy('https://unsrat.ac.id')
            ->permittedFor('https://unsrat.ac.id') 
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+30 minutes'))
            ->withClaim('id', $user['user_id'])
            ->withClaim('name', $user['name'])
            ->withClaim('username', $user['username'])
            ->withClaim('role_id', $user['role_id'])
            ->withClaim('token_type', 'access')
            ->getToken($config->signer(), $config->signingKey());

        $refresh_token = $config->builder()
            ->issuedBy('https://unsrat.ac.id')
            ->permittedFor('https://unsrat.ac.id')
            ->issuedAt($now)
            ->expiresAt($now->modify('+7 days'))
            ->withClaim('id', $user['user_id'])
            ->withClaim('token_type', 'refresh')
            ->getToken($config->signer(), $config->signingKey());

        return [
            'access_token' => $access_token->toString(),
            'refresh_token' => $refresh_token->toString()
        ];
    }

    public static function validateToken(string $token): string
    {
        $config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(ROOTPATH . 'private.key'), 
            InMemory::file(ROOTPATH . 'public.key')
        );

        try {
            $jwt = $config->parser()->parse($token);
            $now = new \DateTimeImmutable();

            if (!$config->validator()->validate($jwt, new \Lcobucci\JWT\Validation\Constraint\SignedWith($config->signer(), $config->verificationKey()))) {
                return "Token tidak valid";
            }

            if ($jwt->isExpired($now)) {
                return "Token sudah kadaluarsa";
            }

            return "Token valid";
        } catch (\Exception $e) {
            return "Token tidak valid";
        }
    }

    public static function decodeAccessToken(string $token)
    {
        return self::decodeToken($token);
    }

    public static function decodeRefreshToken(string $token)
    {
        return self::decodeToken($token);
    }

    private static function decodeToken(string $token)
    {
        $key = file_get_contents(ROOTPATH . 'public.key'); // Asumsi menggunakan kunci publik untuk verifikasi

        try {
            // Decode token menggunakan library firebase/php-jwt
            $decoded = FirebaseJWT::decode($token, new Key($key, 'RS256')); // Ganti 'HS256' dengan 'RS256' jika menggunakan RSA
            return (array) $decoded;
        } catch (\Exception $e) {
            return null; // Gagal decode token
        }
    }
}