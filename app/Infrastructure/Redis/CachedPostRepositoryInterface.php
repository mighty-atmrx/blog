<?php

namespace App\Infrastructure\Redis;

use App\Domain\Post\Entity\Post;
use Illuminate\Database\Eloquent\Collection;

interface CachedPostRepositoryInterface
{
    public function getAll(): Collection;
    public function getByIdentifier(int|string $identifier): ?Post;
    public function getByUserId(int $userId): ?Collection;
    public function save(Post $post): void;
    public function delete(Post $post): void;
}
