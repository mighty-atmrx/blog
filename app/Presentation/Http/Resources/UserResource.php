<?php

namespace App\Presentation\Http\Resources;

use App\Domain\User\Entity\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @var User $this->resource */
class UserResource extends JsonResource
{
    protected Collection $posts;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
        ];
    }

    public function withPosts(Collection $posts): UserResource
    {
        $this->posts = $posts;
        return $this;
    }
}
