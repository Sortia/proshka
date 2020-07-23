<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'id',
        'course_id',
        'name',
        'description',
        'order_number',
        'cost',
        'bonus',
        'fine',
        'text',
        'video',
        'file',
        'complexity',
        'time',
        'available_at',
        'task',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function user()
    {
        return $this->hasOne(LessonUser::class)->where('user_id', auth()->user()->id);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
