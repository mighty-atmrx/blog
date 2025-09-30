<?php

namespace App\Domain\Post\Repository;

use App\Domain\Post\Entity\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function getAll(): Collection;
    public function getByIdentifier(string|int $identifier): ?Post;
    public function getByUserId(int $userId): ?Collection;
    public function create(array $data): Post;
}
