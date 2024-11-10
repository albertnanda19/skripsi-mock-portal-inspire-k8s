<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api/v1', function($routes) {
    $routes->get('test', 'Home::test');
    $routes->post('login', 'AuthController::login');

    $routes->group('users', ['filter' => 'jwt'], function($routes) {
        $routes->get('students', 'UserController::students'); 
        $routes->get('teachers', 'UserController::teachers');
    });

    $routes->get('courses', 'CourseController::index');

    $routes->group('attendance', ['filter' => 'jwt'], function($routes) {
        $routes->post('generate-code', 'AttendanceController::generateCode');
    });
});