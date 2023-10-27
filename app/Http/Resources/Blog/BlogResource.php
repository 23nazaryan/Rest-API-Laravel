<?php

declare(strict_types=1);

namespace App\Http\Resources\Blog;

use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Like\LikeCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'attachment' => $this->attachment->url,
            'comments' => new CommentCollection($this->comments),
            'likes' => new LikeCollection($this->likes),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
