<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Dto\UserCreateDto;
use App\Domain\User\Dto\UserDto;
use App\Domain\User\Dto\UserUpdateDto;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?UserDto;
    public function register(UserCreateDto $data): UserDto;
    public function update(UserUpdateDto $data, int $id): UserDto;
    public function delete(int $id): void;
}
