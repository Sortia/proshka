<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
