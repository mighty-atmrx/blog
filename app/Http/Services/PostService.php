<?php

namespace App\Http\Services;

use App\Application\Post\Dto\CreatePostDto;
use App\Application\Post\Dto\PostDto;
use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PostService extends BaseService
{
    public function __construct(
        private readonly PostRepository $repository,
    ){
    }

    public function getAll(): ?Collection
    {
        return Cache::remember('posts:all', 60*60, function () {
            $posts = $this->repository->getAll();
            return $posts->isNotEmpty() ? $posts : null;
        });
    }

    public function getByIdentifier(string|int $identifier): ?Post
    {
        if (is_numeric($identifier)) {
            $post = Cache::get("posts:id:{$identifier}");
        } else {
            $post = Cache::get("posts:slug:{$identifier}");
        }

        if (!$post) {
            $post = $this->repository->getByIdentifier($identifier);
            if ($post) {
                Cache::put("posts:id:{$post->getId()}", $post);
                Cache::put("posts:slug:{$post->getSlug()}", $post);
            }
        }

        return $post;
    }

    public function getByUserId(int $userId): ?Collection
    {
        if (!$userId) {
            return null;
        }

        $posts = Cache::get("posts:user_id:{$userId}");

        if (!$posts) {
            $posts = Cache::remember("posts:user_id:{$userId}", 60*60*24, function () use ($userId) {
                return $this->repository->getByUserId($userId);
            });
        }

        return $posts;
    }

    public function create(array $data): PostDto
    {
        $post = $this->repository->create($data);
        Cache::put('posts:id:'.$post->getId(), $post);
        Cache::put('posts:slug:'.$post->getSlug(), $post);
        return PostDto::fromEntity($post);
    }
}
