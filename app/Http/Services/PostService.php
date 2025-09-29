<?php

namespace App\Http\Services;

use App\Http\Repositories\PostRepository;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PostService
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
}
