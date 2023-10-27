<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Insert the user's profile information.
     *
     * @param array $requestData
     * @return Builder|Model
     */
    public function create(array $requestData): Builder|Model
    {
        return User::query()->create($requestData);
    }

    /**
     * Update the user's profile information.
     *
     * @param User $user
     * @param array $requestData
     * @return void
     */
    public function update(User $user, array $requestData): void
    {
        $user->fill($requestData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }
}
