<?php

namespace App\Domain\Post\Repository;

use App\Domain\Post\Entity\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        return Post::all();
    }

    public function getByIdentifier(string|int $identifier): ?Post
    {
        if (is_numeric($identifier)) {
            return Post::find($identifier);
        } else {
            return Post::where('slug', $identifier)->first();
        }
    }

    public function getByUserId(int $userId): ?Collection
    {
        return Post::where('user_id', $userId)->get();
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }
}
