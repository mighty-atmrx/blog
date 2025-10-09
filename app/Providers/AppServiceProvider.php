<?php

namespace App\Providers;

use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Redis\CachedPostRepository;
use App\Infrastructure\Redis\CachedUserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, function ($app) {
            return new CachedPostRepository(
                new PostRepository(),
                $app->make(CacheRepository::class)
            );
        });

        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return new CachedUserRepository(
                new UserRepository(),
                $app->make(CacheRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
