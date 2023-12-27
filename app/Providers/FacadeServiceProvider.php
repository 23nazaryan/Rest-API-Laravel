<?php

namespace App\Providers;

use App\Services\ArticleService;
use App\Services\CommentService;
use App\Services\AttachmentService;
use App\Services\LikeService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('Article', ArticleService::class);
        $this->app->bind('Comment', CommentService::class);
        $this->app->bind('Like', LikeService::class);
        $this->app->bind('User', UserService::class);
        $this->app->bind('Attachment', AttachmentService::class);
    }
}
