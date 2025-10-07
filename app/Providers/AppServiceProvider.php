<?php

namespace App\Providers;

use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Infrastructure\Redis\CachedPostRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
