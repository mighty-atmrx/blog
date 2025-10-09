<?php

namespace App\Http\Services\User;

use App\Domain\User\Dto\UserCreateDto;
use App\Domain\User\Dto\UserDto;
use App\Domain\User\Dto\UserUpdateDto;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserPassword;
use App\Http\Services\BaseService;

class UserCommandService extends BaseService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserPassword $passwordHashed
    ){
    }

    public function register(UserCreateDto $data): UserDto
    {
        $data['password'] = $this->passwordHashed->hash($data['password']);
        return $this->repository->register($data);
    }

    public function update(UserUpdateDto $data, int $userId): UserDto
    {
        return $this->repository->update($data, $userId);
    }

    public function delete(int $userId): void
    {
        $this->repository->delete($userId);
    }
}
