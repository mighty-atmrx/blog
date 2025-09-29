<?php

namespace App\Http\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
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
}
