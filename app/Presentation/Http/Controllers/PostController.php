<?php

namespace App\Presentation\Http\Controllers;

use App\Http\Services\Post\PostCommandService;
use App\Http\Services\Post\PostQueryService;
use App\Presentation\Http\Requests\Post\CreateRequest;
use App\Presentation\Http\Requests\Post\UpdateRequest;
use App\Presentation\Http\Resources\PostResource;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        } catch (\Throwable $e) {
            $this->logger->error('Get all posts error. ', ['error' => $e->getMessage()]);
            return response()->json(
                ['error' => 'Unable to retrieve posts. Please try again later.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getByIdentifier($identifier): JsonResponse
    {
        try {
            $post = $this->queryService->getByIdentifier($identifier);
            return response()->json(new PostResource($post), Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Get post by identifier error. ', [
                'error' => $e->getMessage(),
                'identifier' => $identifier
            ]);
            return response()->json(
                ['error' => 'Unable to retrieve post by identifier. Please try again later.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getByUserId(int $userId): JsonResponse
    {
        try {
            $posts = $this->queryService->getByUserId($userId);
            return response()->json(PostResource::collection($posts), Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error("Get user's posts error: " . $e->getMessage());
            return response()->json(
                ['error' => 'Unable to retrieve user posts. Please try again later.'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function create(CreateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $post = $this->commandService->create($data);
            return response()->json(new PostResource($post), Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            $this->logger->error('Unable to create post.', ['error' => $e->getMessage()]);
            return response()->json(
                ['error' => 'Unable to create post. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $post = $this->commandService->update($data, $id);
            return response()->json(new PostResource($post), Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Unable to update post.', ['post_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(
                ['error' => 'Unable to update post. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->commandService->delete($id);
            return response()->json(['message' => 'Post deleted successfully'], Response::HTTP_OK);
        } catch (\Throwable $e) {
            $this->logger->error('Unable to delete post.', ['post_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(
                ['error' => 'Unable to delete post. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }


}
