<?php

namespace App\Http\Services\Post;

use App\Domain\Post\Dto\PostDto;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Http\Services\BaseService;

class PostCommandService extends BaseService
{
    public function __construct(
        private readonly PostRepositoryInterface $repository,
    ) {
    }

    public function create(array $data): PostDto
    {
//        $data['user_id'] = auth()->id();
        $post = $this->repository->create($data);
        return PostDto::fromEntity($post);
    }

    public function update(array $data, int $id): PostDto
    {
        $post = $this->repository->update($data, $id);
        return PostDto::fromEntity($post);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
