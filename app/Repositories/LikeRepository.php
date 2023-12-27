<?php

namespace App\Repositories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CRUDRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LikeRepository implements CRUDRepositoryInterface
{
    public function __construct(private readonly Like $model)
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
    }

    public function delete(int $id): bool
    {
        $like = $this->getById($id);
        return $like?->delete();
    }
}
