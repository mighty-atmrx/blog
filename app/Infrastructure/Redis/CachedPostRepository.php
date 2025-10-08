<?php

namespace App\Infrastructure\Redis;

use App\Application\Post\Exception\PostNotFoundException;
use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Repository\PostRepositoryInterface;
use Exception;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Psr\SimpleCache\InvalidArgumentException;

readonly class CachedPostRepository implements PostRepositoryInterface
{
    public function __construct(
        private PostRepository $repository,
        private CacheRepository $cache
    ) {}

    public function getAll(): array
    {
        return $this->cache->remember('posts:all', 60 * 60 * 24, function () {
            return $this->repository->getAll();
        });
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getByIdentifier(int|string $identifier): ?Post
    {
        if (is_numeric($identifier)) {
            $post = $this->cache->get("posts:id:{$identifier}");
        } else {
            $post = $this->cache->get("posts:slug:{$identifier}");
        }

        if (!$post) {
            $post = $this->repository->getByIdentifier($identifier);
        }

        return $post;
    }

    public function getByUserId(int $userId): ?array
    {
        return $this->cache->remember("posts:user_id:{$userId}", 60 * 60 * 24, function () use ($userId) {
            return $this->repository->getByUserId($userId);
        });
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Post
    {
        $post = $this->repository->create($data);
        $this->cache->put('posts:id:' . $post->getId(), $post, 86400);
        $this->cache->put('posts:slug:' . $post->getSlug(), $post, 86400);
        $this->cache->forget('posts:all');
        return $post;
    }

    /**
     * @throws PostNotFoundException
     */
    public function update(array $data, int $id): Post
    {
        $post = $this->repository->update($data, $id);
        $this->cache->put('posts:id:' . $post->getId(), $post, 86400);
        $this->cache->put('posts:slug:' . $post->getSlug(), $post, 86400);
        $this->cache->forget('posts:all');
        return $post;
    }

    /**
     * @throws PostNotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(int $id): void
    {
        $post = $this->getByIdentifier($id);
        if (!$post) {
            throw new PostNotFoundException();
        }

        $this->cache->forget("posts:id:{$post->getId()}");
        $this->cache->forget("posts:slug:{$post->getSlug()}");
        $this->repository->delete($id);
    }
}
