<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Services\Post\PostCommandService;
use App\Http\Services\Post\PostQueryService;
use App\Presentation\Http\Requests\Post\CreateRequest;
use App\Presentation\Http\Requests\Post\UpdateRequest;
use App\Presentation\Http\Resources\PostResource;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PostController extends Controller
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly PostQueryService $queryService,
        private readonly PostCommandService $commandService
    ) {
    }

    public function getAll(): JsonResponse
    {
        try {
            $posts = $this->queryService->getAll();
            return response()->json(PostResource::collection($posts), Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error('Get all posts error. ', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'get_all_posts_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    public function getByIdentifier($identifier): JsonResponse
    {
        try {
            $post = $this->queryService->getByIdentifier($identifier);
            return response()->json(new PostResource($post), Response::HTTP_OK);
        } catch (Throwable $e) {
            $this->logger->error('Get post by identifier error. ', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'get_post_by_identifier_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getByUserId(int $userId): JsonResponse
    {
        try {
            $posts = $this->queryService->getByUserId($userId);
            return response()->json(PostResource::collection($posts), Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error("Get user's posts error: " . $e->getMessage());
            return response()->json([
                'error' => 'Unable to retrieve user posts. Please try again later.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(CreateRequest $request): JsonResponse
    {
        try {
            $data = $request->validationData();
            $post = $this->commandService->create($data);
            // event for increment user posts count, community posts count
            return response()->json(new PostResource($post), Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            $this->logger->error('Post create error.', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'post_create_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $post = $this->commandService->update($data, $id);
            return response()->json(new PostResource($post), Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Post update error.', ['post_id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'error' => 'post_update_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->commandService->delete($id);
            // event for decrement user posts count, community posts count
            return response()->json(['message' => 'post_deleted_successfully'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Post delete error', ['post_id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'error' => 'post_delete_error',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
