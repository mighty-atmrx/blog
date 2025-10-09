<?php

namespace App\Domain\User\Repository;

use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\Dto\UserCreateDto;
use App\Domain\User\Dto\UserDto;
use App\Domain\User\Dto\UserUpdateDto;
use App\Domain\User\Entity\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(): array
    {
        return User::all()->map(fn (User $user) => UserDto::fromEntity($user)->toArray());
    }

    public function getById(int $id): ?UserDto
    {
        $user = User::query()->find($id);
        return $user ? UserDto::fromEntity($user) : null;
    }

    public function register(UserCreateDto $data): UserDto
    {
        $user = User::query()->create($data->toArray());
        return UserDto::fromEntity($user);
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(UserUpdateDto $data, int $id): UserDto
    {
        $user = User::query()->find($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $user->update($data->toArray());
        return UserDto::fromEntity($user);
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(int $id): void
    {
        $user = User::query()->find($id);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $user->delete();
    }
}
