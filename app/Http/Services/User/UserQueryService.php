<?php

namespace App\Http\Services\User;

use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\Dto\UserDto;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Http\Services\BaseService;
use Exception;

class UserQueryService extends BaseService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ){
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    /**
     * @throws Exception
     */
    public function getById(int $userId): ?UserDto
    {
        $user = $this->repository->getById($userId);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return UserDto::fromEntity($user);
    }
}
