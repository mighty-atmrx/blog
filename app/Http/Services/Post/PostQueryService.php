<?php

namespace App\Http\Services\Post;

use App\Application\Post\Exception\PostNotFoundException;
use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Psr\Log\LoggerInterface;

class PostQueryService extends BaseService
{
    public function __construct(
        private readonly PostRepositoryInterface $repository,
        private readonly LoggerInterface $logger
    ) {
    }

    public function getAll(): ?Collection
    {
        return $this->repository->getAll();
    }

    /**
     * @throws PostNotFoundException
     */
    public function getByIdentifier(string|int $identifier): ?Post
    {
        $post = $this->repository->getByIdentifier($identifier);
        if (!$post) {
            $this->logger->error('Post not found. ', ['identifier' => $identifier]);
            throw new PostNotFoundException();
        }
        return $post;
    }

    /**
     * @throws Exception
     */
    public function getByUserId(int $userId): ?Collection
    {
        if (!$userId) {
            throw new Exception('user_id_is_required');
        }
        return $this->repository->getByUserId($userId);
    }
}
