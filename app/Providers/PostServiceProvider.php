<?php

namespace App\Providers;

use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Infrastructure\Redis\CachedPostRepository;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, CachedPostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
