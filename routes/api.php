<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ArticleController;

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Article
    Route::apiResource('articles', ArticleController::class);

    // Comment
    Route::apiResource('comments', CommentController::class);

    // Like
    Route::get('likes', [LikeController::class, 'index']);
    Route::post('likes', [LikeController::class, 'store']);
    Route::delete('likes/{like}', [LikeController::class, 'destroy']);
});

require __DIR__ . '/auth.php';
