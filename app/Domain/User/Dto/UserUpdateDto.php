<?php

namespace App\Domain\User\Dto;

class UserUpdateDto
{
    public function __construct(
        public ?string $username = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $password = null,
    ){
    }

    public function toArray(): array
    {
        return array_filter([
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ], fn($value) => $value !== null);
    }
}
