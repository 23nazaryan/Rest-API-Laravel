<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = ['id'];

    public function getUrlAttribute(): string
    {
        return asset('/storage/attachments/' . $this->name);
    }
}
