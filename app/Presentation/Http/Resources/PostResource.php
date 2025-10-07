<?php

namespace App\Presentation\Http\Resources;

use App\Domain\Post\Dto\PostDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var PostDto $dto */
        $dto = $this->resource;

        return $dto->toArray();
    }
}
