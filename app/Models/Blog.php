<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'item');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'item');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'item');
    }
}
