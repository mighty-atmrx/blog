<?php

namespace App\Http\Interfaces;

interface PostEntityInterface
{
    public function getId(): int;
    public function getTitle(): string;
    public function getContent(): string;
    public function getImage(): string;
    public function getSlug(): string;
    public function getCommunityId(): int;
    public function getUserId(): int;
    public function getViews(): int;
    public function getLikes(): int;
    public function getReposts(): int;
    public function getPublicationDate(): \DateTimeImmutable;
    public function getModificationDate(): \DateTimeImmutable;
    public function getDeletionDate(): ?\DateTimeImmutable;
}
