<?php

namespace App\Providers;

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\NewsController;
use App\Repositories\BlogRepository;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->when(BlogController::class)
            ->needs(CrudRepositoryInterface::class)
            ->give(function () {
                return new BlogRepository();
            });

        $this->app->when(NewsController::class)
            ->needs(CrudRepositoryInterface::class)
            ->give(function () {
                return new NewsRepository();
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
