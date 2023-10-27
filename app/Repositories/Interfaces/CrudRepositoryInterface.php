<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

interface CrudRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator;

    public function getById(int $id): Builder|Model|null;

    public function create(array $requestData): Builder|Model;

    public function update(int $id, array $requestData): void;

    public function delete(int $id): void;
}
