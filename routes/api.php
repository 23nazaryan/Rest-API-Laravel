<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\DeleteCommentController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('blog', BlogController::class);
Route::apiResource('news', NewsController::class);

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    //Blog Comment
    Route::get('/blog/{id}/comment', [BlogController::class, 'getComments']);
    Route::post('/blog/{id}/comment', [BlogController::class, 'addComment']);
    //Blog Like
    Route::get('/blog/{id}/like', [BlogController::class, 'getLikes']);
    Route::post('/blog/{id}/like', [BlogController::class, 'addLike']);
    Route::delete('/blog/{id}/like', [BlogController::class, 'removeLike']);

    //News Comment
    Route::get('/news/{id}/comment', [NewsController::class, 'getComments']);
    Route::post('/news/{id}/comment', [NewsController::class, 'addComment']);
    //News Like
    Route::get('/news/{id}/like', [NewsController::class, 'getLikes']);
    Route::post('/news/{id}/like', [NewsController::class, 'addLike']);
    Route::delete('/news/{id}/like', [NewsController::class, 'removeLike']);

    //Comment delete
    Route::delete('/comment/{id}', [DeleteCommentController::class, 'deleteComment']);
});

require __DIR__ . '/auth.php';
