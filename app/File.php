<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'path',
        'fileable_id',
        'fileable_type',
        'name'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
