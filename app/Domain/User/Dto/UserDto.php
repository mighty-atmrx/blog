<?php

namespace App\Domain\User\Dto;

use App\Domain\User\Entity\User;
use DateTimeImmutable;

readonly class UserDto
{
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public ?string $phone,
        public ?DateTimeImmutable $email_verified_at,
        public DateTimeImmutable $created_at,
        public DateTimeImmutable $updated_at,
    ){
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->getId(),
            username: $user->getUsername(),
            email: $user->getEmail(),
            phone: $user->getPhone(),
            email_verified_at: $user->getEmailVerifiedAt(),
            created_at: $user->getCreatedAt(),
            updated_at: $user->getUpdatedAt(),
        );
    }
}
