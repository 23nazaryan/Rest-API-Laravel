<?php

namespace App\Traits;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;

trait AttachmentTrait
{
    /**
     * Upload and save the attached file.
     *
     * @param UploadedFile $file
     * @return Attachment
     */
    public function uploadFile(UploadedFile $file): Attachment
    {
        $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/attachments', $fileName);

        return (new Attachment([
            'name' => $fileName,
        ]));
    }
}
