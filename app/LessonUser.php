<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    protected $table = 'lesson_user';

    protected $fillable = [
        'id',
        'user_id',
        'lesson_id',
        'status',
        'text',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
