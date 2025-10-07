<?php

namespace App\Domain\Post\Dto;

use App\Domain\Post\Entity\Post;

readonly class PostDto
{
    public function __construct(
        public int $id,
        public string $slug,
        public ?string $title,
        public ?string $content,
        public ?string $image,
        public int $userId,
        public int $communityId,
        public int $views,
        public int $likes,
        public int $reposts,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'slug' => $this->slug,
            'user_id' => $this->userId,
            'community_id' => $this->communityId,
            'views' => $this->views,
            'likes' => $this->likes,
            'reposts' => $this->reposts,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public static function fromEntity(Post $post): self
    {
        return new self(
            id: $post->getId(),
            slug: $post->getSlug(),
            title: $post->getTitle(),
            content: $post->getContent(),
            image: $post->getImage(),
            userId: $post->getUserId(),
            communityId: $post->getCommunityId(),
            views: $post->getViews(),
            likes: $post->getLikes(),
            reposts: $post->getReposts(),
            createdAt: $post->getPublicationDate(),
            updatedAt: $post->getModificationDate(),
        );
    }
}
