<?php

namespace App\Helpers;

use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Response
{
   
    public static function send(int $status, string $message, $data = null): ResponseInterface
    {
        $response = Services::response();
        $responseBody = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        return $response->setJSON($responseBody)->setStatusCode($status);
    }
}