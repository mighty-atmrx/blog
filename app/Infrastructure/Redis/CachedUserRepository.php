<?php

namespace App\Infrastructure\Redis;

use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\Dto\UserCreateDto;
use App\Domain\User\Dto\UserDto;
use App\Domain\User\Dto\UserUpdateDto;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

readonly class CachedUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private UserRepository $repository,
        private CacheRepository $cache
    ){
    }

    public function getAll(): array
    {
        return $this->cache->remember('users:all', 60 * 60 * 24, function () {
            return $this->repository->getAll();
        });
    }

    public function getById(int $id): ?UserDto
    {
        return $this->cache->remember('users:id:' . $id, 60 * 60 * 24, function () use ($id) {
            return $this->repository->getById($id);
        });
    }

    public function register(UserCreateDto $data): UserDto
    {
        $user = $this->repository->register($data);
        $this->cache->put('users:id:' . $user->id, $user, 60 * 60 * 24);
        $this->cache->forget('users:all');
        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(UserUpdateDto $data, int $id): UserDto
    {
        $user = $this->repository->update($data, $id);
        $this->cache->put('users:id:' . $user->id, $user, 60 * 60 * 24);
        $this->cache->forget('users:all');
        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
        $this->cache->forget('users:id:' . $id);
        $this->cache->forget('users:all');
    }
}
