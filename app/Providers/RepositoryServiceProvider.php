<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\LikeService;
use App\Services\ArticleService;
use App\Services\CommentService;
use App\Repositories\LikeRepository;
use App\Repositories\UserRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ArticleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CRUDRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // User
        $this->app->when(UserService::class)
            ->needs(CRUDRepositoryInterface::class)
            ->give(UserRepository::class);

        // Article
        $this->app->when(ArticleService::class)
            ->needs(CRUDRepositoryInterface::class)
            ->give(ArticleRepository::class);

        // Comment
        $this->app->when(CommentService::class)
            ->needs(CRUDRepositoryInterface::class)
            ->give(CommentRepository::class);

        // Like
        $this->app->when(LikeService::class)
            ->needs(CRUDRepositoryInterface::class)
            ->give(LikeRepository::class);
    }
}
