<?php

namespace App\Infrastructure\Redis;

use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Psr\SimpleCache\CacheInterface;

readonly class CachedPostRepository implements CachedPostRepositoryInterface
{
    public function __construct(
        private PostRepositoryInterface $repository,
        private CacheInterface $cache
    ) {}

    public function getAll(): Collection
    {
        return $this->cache->remember('posts:all', 60 * 60 * 24, function () {
            $posts = $this->repository->getAll();
            return $posts->isNotEmpty() ? $posts : new Collection();
        });
    }

    public function getByIdentifier(int|string $identifier): ?Post
    {
        if (is_numeric($identifier)) {
            return $this->cache->get("posts:id:{$identifier}");
        } else {
            return $this->cache->get("posts:slug:{$identifier}");
        }
    }

    public function getByUserId(int $userId): ?Collection
    {
        $posts = $this->cache->get("posts:user_id:{$userId}");

        if (!$posts) {
            $posts = $this->cache->remember("posts:user_id:{$userId}", 60 * 60 * 24, function () use ($userId) {
                return $this->repository->getByUserId($userId);
            });
        }

        return $posts;
    }

    public function save(Post $post): void
    {
        $this->cache->put('posts:id:' . $post->getId(), $post, 60*60*24);
        $this->cache->put('posts:slug:' . $post->getSlug(), $post, 60*60*24);
    }

    public function delete(Post $post): void
    {
        $this->cache->forget("posts:id:{$post->getId()}");
        $this->cache->forget("posts:slug:{$post->getSlug()}");
    }
}
