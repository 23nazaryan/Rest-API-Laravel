<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\CRUDRepositoryInterface;

class CommentRepository implements CRUDRepositoryInterface
{
    public function __construct(private readonly Comment $model)
    {
    }

    public function getAll(array $requestData): LengthAwarePaginator
    {
        $articleID = $requestDatap['article_id'] ?? null;

        return $this->model->newQuery()
            ->when($articleID, function ($q) use ($articleID) {
                $q->where('article_id', $articleID);
            })->paginate();
    }

    public function getById(int $id): Model|Builder
    {
        return $this->model->newQuery()
            ->findOrFail($id);
    }

    public function create(array $requestData): Model|Builder
    {
        return $this->model->newQuery()
            ->create($requestData);
    }

    public function update(int $id, array $requestData): bool
    {
        return $this->getById($id)
            ->update($requestData);
    }

    public function delete(int $id): bool
    {
        $comment = $this->getById($id);
        return $comment?->delete();
    }
}
