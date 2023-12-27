<?php

namespace App\Facades;

use App\Models\Attachment;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Model|Builder create(array $requestData)
 * @method static bool update(int $id, array $requestData)
 * @method static bool setEmailVerificationCode(int $id)
 * @method static bool checkEmailVerification(int $id, array $requestData)
 * @method static Attachment assignAttachment(int $id, Attachment $attachment)
 */

class UserFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'User';
    }
}
