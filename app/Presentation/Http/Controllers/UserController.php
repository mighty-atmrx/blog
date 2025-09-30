<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function getUser(int $userId): JsonResponse
    {
        try {
            $result = $this->userService->getUser($userId);
            return response()->json($result, Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Get user error.', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
            return response()->json(
                'Unable to retrieve user. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function create(): JsonResponse
    {

    }

    public function update(): JsonResponse
    {

    }

    public function delete(): JsonResponse
    {

    }
}
