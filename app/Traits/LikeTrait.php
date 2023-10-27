<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait LikeTrait
{
    /**
     * Add like.
     *
     * @param User $user
     * @param Builder|Model $item
     * @return Builder|Model
     */
    public function addLike(User $user, Builder|Model $item): Builder|Model
    {
        $like = new Like(['user_id' => $user->id]);
        return $item->likes()->save($like);
    }

    /**
     * Remove like.
     *
     * @param User $user
     * @param Builder|Model $item
     * @return void
     */
    public function removeLike(User $user, Builder|Model $item): void
    {
        $item->likes()->where('user_id', $user->id)?->delete();
    }
}
