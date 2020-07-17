<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'direction_id'
    ];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

}
