<?php

namespace App\Traits;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait CommentTrait
{
    /**
     * Add comment.
     *
     * @param User $user
     * @param array $requestData
     * @param Builder|Model $item
     * @return Builder|Model
     */
    public function addComment(User $user, array $requestData, Builder|Model $item): Builder|Model
    {
        $comment = new Comment([
            'message' => $requestData['message'],
            'user_id' => $user->id
        ]);

        return $item->comments()->save($comment);
    }

    /**
     * Delete comment.
     *
     * @param int $id
     * @return void
     */
    public function deleteComment(int $id): void
    {
        Comment::query()->find($id)->delete();
    }
}
