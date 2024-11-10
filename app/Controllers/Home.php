<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function test()
    {
        return $this->response->setJSON(['message' => 'Hello, World!']);
    }
}