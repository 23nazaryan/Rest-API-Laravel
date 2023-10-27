<?php

namespace App\Services;

use App\Models\News;
use App\Traits\AttachmentTrait;
use App\Traits\CommentTrait;
use App\Traits\LikeTrait;
use Illuminate\Http\UploadedFile;

class NewsService
{
    use AttachmentTrait, CommentTrait, LikeTrait;

    /**
     * Upload and save the news attached file.
     *
     * @param int $id
     * @param UploadedFile $file
     * @return void
     */
    public function uploadAttachment(int $id, UploadedFile $file): void
    {
        $attachment = $this->uploadFile($file);
        $news = News::query()->find($id);
        $news->attachment()->delete();
        $news->attachment()->save($attachment);
    }
}
