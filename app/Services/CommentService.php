<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CRUDRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentService
{
    public function __construct(private readonly CRUDRepositoryInterface $repository)
    {
    }

    public function getAll(array $requestData): LengthAwarePaginator
    {
        return $this->repository->getAll($requestData);
    }

    public function getById(int $id): Model|Builder
    {
        return $this->repository->getById($id);
    }

    public function create(array $requestData): Model|Builder
    {
        return $this->repository->create($requestData);
    }

    public function update(int $id, array $requestData): bool
    {
        return $this->repository->update($id, $requestData);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
