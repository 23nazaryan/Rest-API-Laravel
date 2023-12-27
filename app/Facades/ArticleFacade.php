<?php

namespace App\Facades;

use App\Models\Attachment;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @method static LengthAwarePaginator getAll(array $requestData)
 * @method static Model|Builder getById(int $id)
 * @method static Model|Builder create(array $requestData)
 * @method static bool update(int $id, array $requestData)
 * @method static bool delete(int $id)
 * @method static Attachment assignAttachment(int $id, Attachment $attachment)
 */

class ArticleFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Article';
    }
}
