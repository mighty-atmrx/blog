<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Presentation\Http\Resources\UserResource;

class UserService extends BaseService
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly PostService $postService,
    ){
    }

    public function getUser(int $userId): ?UserResource
    {
        if (!$userId) {
            return null;
        }

        $user = $this->repository->getUser($userId);
        $posts = $this->postService->getByUserId($userId);

        return UserResource::make($user)->withPosts($posts);
    }
}
