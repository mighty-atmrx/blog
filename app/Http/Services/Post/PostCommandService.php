<?php

namespace App\Http\Services\Post;

use App\Application\Post\Exception\PostNotFoundException;
use App\Domain\Post\Dto\PostDto;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Http\Services\BaseService;
use App\Infrastructure\Redis\CachedPostRepositoryInterface;

class PostCommandService extends BaseService
{
    public function __construct(
        private readonly PostRepositoryInterface $repository,
        private readonly CachedPostRepositoryInterface $cachedRepository
    ) {
    }

    public function create(array $data): PostDto
    {
        $post = $this->repository->create($data);
        $this->cachedRepository->save($post);
        return PostDto::fromEntity($post);
    }

    public function update(array $data, int $id): PostDto
    {
        $post = $this->repository->update($data, $id);
        $this->cachedRepository->save($post);
        return PostDto::fromEntity($post);
    }

    /**
     * @throws PostNotFoundException
     */
    public function delete(int $id): void
    {
        $post = $this->repository->getByIdentifier($id);

        if (!$post) {
            throw new PostNotFoundException();
        }

        $this->cachedRepository->delete($post);
        $this->repository->delete($id);
    }
}
