<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

interface UserRepositoryInterface
{
    public function create(array $requestData): Builder|Model;

    public function update(User $user, array $requestData);
}
