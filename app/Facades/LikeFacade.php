<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @method static LengthAwarePaginator getAll(array $requestData)
 * @method static Model|Builder create(array $requestData)
 * @method static bool delete(int $id)
 */

class LikeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Like';
    }
}
