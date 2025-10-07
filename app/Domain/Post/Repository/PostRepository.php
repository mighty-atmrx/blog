<?php

namespace App\Domain\Post\Repository;

use App\Application\Post\Exception\PostNotFoundException;
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

    /**
     * @throws PostNotFoundException
     */
    public function update(array $data, int $id): Post
    {
        $post = Post::find($id);
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
