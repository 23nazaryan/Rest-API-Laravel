<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\CRUDRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements CRUDRepositoryInterface
{
    public function __construct(private readonly Article $model)
    {
    }

    /**
     * @param array $requestData
     * @return LengthAwarePaginator
     */
    public function getAll(array $requestData): LengthAwarePaginator
    {
        $search = $requestData['search'] ?? null;

        return $this->model->newQuery()
            ->with('comments', 'likes')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('tags', 'like', "%$search%");
            })->paginate();
    }

    /**
     * @param int $id
     * @return Model|Builder
     */
    public function getById(int $id): Model|Builder
    {
        return $this->model->newQuery()
            ->with('comments', 'likes')
            ->findOrFail($id);
    }

    /**
     * @param array $requestData
     * @return Model|Builder
     */
    public function create(array $requestData): Model|Builder
    {
        return $this->model->newQuery()
            ->create($requestData);
    }

    /**
     * @param int $id
     * @param array $requestData
     * @return bool
     */
    public function update(int $id, array $requestData): bool
    {
        return $this->getById($id)
            ->update($requestData);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->getById($id)
            ->delete();
    }
}
