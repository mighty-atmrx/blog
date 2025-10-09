<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\User\Dto\UserCreateDto;
use App\Domain\User\Dto\UserUpdateDto;
use App\Http\Services\User\UserCommandService;
use App\Http\Services\User\UserQueryService;
use App\Presentation\Http\Requests\User\CreateRequest;
use App\Presentation\Http\Requests\User\UpdateRequest;
use App\Presentation\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly UserQueryService $queryService,
        private readonly UserCommandService $commandService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function getAll(): JsonResponse
    {
        try {
            $users = $this->queryService->getAll();
            return response()->json(UserResource::collection($users), Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error('Get all users error.', [
                'error' => $e->getMessage()
            ]);
            return response()->json(
                'Unable to retrieve users. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getUser(int $userId): JsonResponse
    {
        try {
            $user = $this->queryService->getById($userId);
            return response()->json(new UserResource($user), Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error('Get user error.', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
            return response()->json([
                'error' => 'get_user_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(CreateRequest $request): JsonResponse
    {
        try {
            $data = new UserCreateDto(...$request->validated());
            $user = $this->commandService->register($data);
            return response()->json(new UserResource($user), Response::HTTP_CREATED);
        } catch (Throwable $e) {
            $this->logger->error("User registration error.", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'user_registration_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateRequest $request, int $userId): JsonResponse
    {
        try {
            $data = new UserUpdateDto(...$request->validated());
            $user = $this->commandService->update($data, $userId);
            return response()->json(new UserResource($user), Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error("User update error.", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'user_update_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $userId): JsonResponse
    {
        try {
            $this->commandService->delete($userId);
            return response()->json('user_deleted_successfully', Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error("User delete error.", [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'user_delete_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
