<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepository;
use App\Http\Services\PostService;
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
        private readonly PostService $postService
    ) {
    }

    public function getAll(): JsonResponse
    {
        try {
            $posts = $this->postService->getAll();
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
            $post = $this->postService->getByIdentifier($identifier);
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
            $posts = $this->postService->getByUserId($userId);
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
            $post = $this->postService->create($data);
            return response()->json(new PostResource($post), Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            $this->logger->error('Unable to create user. Please try again later.');
            return response()->json(
                ['error' => 'Unable to create user. Please try again later.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $post = $this->postService->update();
            return response()->json(new PostResource($post), Response::HTTP_OK);
        } catch (\Throwable $e) {

        }
    }

    public function delete(): JsonResponse
    {

    }


}
