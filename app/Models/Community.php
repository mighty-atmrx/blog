<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    /** @use HasFactory<\Database\Factories\CommunityFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'subscribers',
        'posts'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
