<?php

namespace App\Facades;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Attachment uploadFile(UploadedFile $file)
 */

class AttachmentFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Attachment';
    }
}
