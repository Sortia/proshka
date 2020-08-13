<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'path',
        'fileable_id',
        'fileable_type',
        'name',
        'user_id'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
