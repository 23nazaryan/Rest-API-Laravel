<?php

namespace App\Services;

use App\Models\Blog;
use App\Traits\AttachmentTrait;
use App\Traits\CommentTrait;
use App\Traits\LikeTrait;
use Illuminate\Http\UploadedFile;

class BlogService
{
    use AttachmentTrait, CommentTrait, LikeTrait;

    /**
     * Upload and save the blog's attached file.
     *
     * @param int $id
     * @param UploadedFile $file
     * @return void
     */
    public function uploadAttachment(int $id, UploadedFile $file): void
    {
        $attachment = $this->uploadFile($file);
        $blog = Blog::query()->find($id);
        $blog->attachment()->delete();
        $blog->attachment()->save($attachment);
    }
}
