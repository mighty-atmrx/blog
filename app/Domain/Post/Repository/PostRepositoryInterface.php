<?php

namespace App\Domain\Post\Repository;

use App\Domain\Post\Entity\Post;

interface PostRepositoryInterface
{
    public function getAll(): array;
    public function getByIdentifier(string|int $identifier): ?Post;
    public function getByUserId(int $userId): ?array;
    public function create(array $data): Post;
    public function update(array $data, string|int $identifier): Post;
    public function delete(int $id): void;
}
