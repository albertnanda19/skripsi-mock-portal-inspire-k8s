<?php

namespace App\Middlewares;

use App\Helpers\JWT;
use App\Helpers\Response;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JWTMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $token = $authHeader ? explode(' ', $authHeader)[1] : null;

        if (!$token) {
            return Response::send(401, 'Token tidak disediakan');
        }

        $validationResult = JWT::validateToken($token);
        if ($validationResult !== "Token valid") {
            return Response::send(401, $validationResult);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}