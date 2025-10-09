<?php

namespace App\Domain\User\Dto;

class UserCreateDto
{
    public function __construct(
        public string $username,
        public string $email,
        public ?string $phone,
        public string $password,
    ){
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
