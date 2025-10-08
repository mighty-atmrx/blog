<?php

namespace App\Domain\Post\Dto;

use App\Domain\Post\Entity\Post;
use App\Domain\Post\Enum\StateEnum;
use DateTimeImmutable;

readonly class PostDto
{
    public function __construct(
        public int $id,
        public string $slug,
        public ?string $title,
        public ?string $content,
        public ?string $image,
        public int $userId,
        public ?int $communityId,
        public StateEnum $state,
        public int $views,
        public int $likes,
        public int $reposts,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public ?DateTimeImmutable $deletedAt,
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
            'state' => $this->state,
            'views' => $this->views,
            'likes' => $this->likes,
            'reposts' => $this->reposts,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deleted_at' => $this->deletedAt,
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
            state: $post->getState(),
            views: $post->getViews(),
            likes: $post->getLikes(),
            reposts: $post->getReposts(),
            createdAt: $post->getPublicationDate(),
            updatedAt: $post->getModificationDate(),
            deletedAt: $post->getDeletionDate(),
        );
    }
}
