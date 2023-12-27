<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CRUDRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements CRUDRepositoryInterface
{
    public function __construct(private readonly User $model)
    {
    }

    public function getAll(array $requestData): LengthAwarePaginator
    {
    }

    /**
     * Insert the user's profile information.
     *
     * @param array $requestData
     * @return Builder|Model
     */
    public function create(array $requestData): Builder|Model
    {
        return $this->model->newQuery()
            ->create($requestData);
    }

    public function getById(int $id): Builder|Model
    {
        return $this->model->newQuery()
            ->findOrFail($id);
    }

    /**
     * Update the user's profile information.
     *
     * @param int $id
     * @param array $requestData
     * @return bool
     */
    public function update(int $id, array $requestData): bool
    {
        $user = $this->getById($id);

        if ($user->isDirty('email')) {
            $requestData['email_verified_at'] = null;
        }

        return $user->update($requestData);
    }

    public function delete(int $id): bool
    {
    }
}
