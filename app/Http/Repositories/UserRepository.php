<?php

namespace App\Http\Repositories;

use App\Domain\User\Entity\User;

class UserRepository
{
    public function getUser(int $userId): User
    {
        return User::find($userId);
    }
}
