<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\PostService;
use App\Models\Post;
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

    public function getByIdentifier($identifier): JsonResponse // by id or slug
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

    public function getByUserId(): JsonResponse
    {

    }

    public function create(CreateRequest $request): Post
    {

    }

    public function update(UpdateRequest $request): Post
    {

    }

    public function delete(): JsonResponse
    {

    }


}
