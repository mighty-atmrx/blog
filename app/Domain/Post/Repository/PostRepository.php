<?php

namespace App\Domain\Post\Repository;

use App\Application\Post\Exception\PostNotFoundException;
use App\Domain\Post\Entity\Post;

class PostRepository implements PostRepositoryInterface
{
    public function getAll(): array
    {
        return Post::all()->toArray();
    }

    public function getByIdentifier(string|int $identifier): ?Post
    {
        if (is_numeric($identifier)) {
            return Post::query()->find($identifier);
        } else {
            $id = explode('-', $identifier);
            $id = end($id);
            return Post::query()->find($id);
        }
    }

    public function getByUserId(int $userId): ?array
    {
        return Post::query()->where('user_id', $userId)->get()->toArray();
    }

    public function create(array $data): Post
    {
        $data['user_id'] = 1;
        return Post::query()->create($data);
    }

    /**
     * @throws PostNotFoundException
     */
    public function update(array $data, int $id): Post
    {
        $post = Post::query()->find($id);
        if (!$post) {
            throw new PostNotFoundException();
        }

        $post->update($data);
        return $post;
    }

    public function delete(int $id): void
    {
        $post = $this->getByIdentifier($id);
        $post->delete();
    }
}
