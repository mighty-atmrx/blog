<?php

namespace App\Http\Services\Post;

use App\Application\Post\Exception\PostNotFoundException;
use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Http\Services\BaseService;
use App\Infrastructure\Redis\CachedPostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PostQueryService extends BaseService
{
    public function __construct(
        private readonly PostRepositoryInterface $repository,
        private readonly CachedPostRepositoryInterface $cachedRepository
    ) {
    }

    public function getAll(): ?Collection
    {
        return $this->cachedRepository->getAll();
    }

    /**
     * @throws PostNotFoundException
     */
    public function getByIdentifier(string|int $identifier): ?Post
    {
        $post = $this->cachedRepository->getByIdentifier($identifier);

        if (!$post) {
            $post = $this->repository->getByIdentifier($identifier);

            if (!$post) {
                throw new PostNotFoundException();
            }

            $this->cachedRepository->save($post);
        }

        return $post;
    }

    public function getByUserId(int $userId): ?Collection
    {
        if (!$userId) {
            return null;
        }

        return $this->cachedRepository->getByUserId($userId);
    }
}
