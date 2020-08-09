<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'id',
        'lesson_id',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
