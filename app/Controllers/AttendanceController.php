<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AttendanceService;
use App\Repositories\AttendanceRepository;
use App\Repositories\CourseRepository;
use App\Helpers\Response;
use App\Helpers\JWT;
use App\Repositories\RoleRepository;
use CodeIgniter\HTTP\ResponseInterface;

class AttendanceController extends BaseController
{
    protected $attendanceService;

    public function __construct()
    {
        $this->attendanceService = new AttendanceService(new AttendanceRepository(), new CourseRepository(), new RoleRepository());
    }

    public function generateCode(): ResponseInterface
    {
        $requestData = $this->request->getJSON(true);

        if (!isset($requestData['course_id'], $requestData['session_number'], $requestData['deadline'])) {
            return Response::send(400, 'Data yang diperlukan tidak lengkap.');
        }

        if (!$this->validateDateTime($requestData['deadline'])) {
            return Response::send(400, 'Format deadline tidak valid. Format yang benar adalah "YYYY-MM-DD HH:MM:SS".');
        }

        if (!is_int($requestData['session_number']) || $requestData['session_number'] < 1 || $requestData['session_number'] > 16) {
            return Response::send(400, 'Session number harus bertipe integer dan berada dalam rentang 1 hingga 16.');
        }

        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = explode(' ', $authHeader)[1] ?? null;
        $decodedToken = JWT::decodeAccessToken($token);
        if (!$decodedToken) {
            return Response::send(401, 'Token tidak valid atau tidak ada.');
        }

        $userId = $decodedToken['id'] ?? null;
        $roleId = $decodedToken['role_id'] ?? null;
        if (!$roleId || !$userId) {
            return Response::send(400, 'Role ID atau User ID tidak ditemukan dalam token.');
        }

        try {
            $code = $this->attendanceService->createAttendanceCode(
                $requestData['course_id'],
                $requestData['session_number'],
                $requestData['deadline'],
                $roleId,
                $userId 
            );
            return Response::send(200, 'Berhasil menghasilkan kode presensi', [
                'attendance_code' => $code,
                'attendance_deadline' => $requestData['deadline']
            ]);
        } catch (\Exception $e) {
            $status = $e->getCode() == 409 ? 409 : 400;
            return Response::send($status, $e->getMessage());
        }
    }

    private function validateDateTime($dateTime): bool
    {
        $d = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $d && $d->format('Y-m-d H:i:s') === $dateTime;
    }
}