<?php

namespace App\Http\Interfaces;

use App\Presentation\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Collection;

interface UserEntityInterface
{
    public function getUserId(UserEntityInterface $user): ?int;
    public function getUser(int $userId): UserResource;
    public function getUserPosts(): ?Collection;
}
