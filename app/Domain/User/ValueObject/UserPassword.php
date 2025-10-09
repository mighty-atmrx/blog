<?php

namespace App\Domain\User\ValueObject;

class UserPassword
{
    public function hash(string $password): string
    {
        return password_hash($password, 'sha256');
    }
}
