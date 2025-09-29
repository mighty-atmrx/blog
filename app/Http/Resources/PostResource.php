<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @var Post $this->resource */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'image' => $this->resource->image,
            'slug' => $this->resource->slug,
            'user_id' => $this->resource->user_id,
            'community_id' => $this->resource->community_id,
        ];
    }
}
