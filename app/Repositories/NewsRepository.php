<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class NewsRepository implements CrudRepositoryInterface
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getAll(Request $request): LengthAwarePaginator
    {
        $limit = $request->get('limit', 25);
        $search = $request->get('q');

        return News::query()->with('comments', 'likes')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('tags', 'like', "%$search%");
            })->paginate($limit);
    }

    /**
     * @param int $id
     * @return Builder|Model|null
     */
    public function getById(int $id): Builder|Model|null
    {
        return News::query()->with('comments', 'likes')->find($id);
    }

    /**
     * @param array $requestData
     * @return Builder|Model
     */
    public function create(array $requestData): Builder|Model
    {
        return News::query()->create($requestData);
    }

    /**
     * @param int $id
     * @param array $requestData
     * @return void
     */
    public function update(int $id, array $requestData): void
    {
        $news = $this->getById($id);

        $news?->update($requestData);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $news = $this->getById($id);

        $news?->delete();
    }
}
