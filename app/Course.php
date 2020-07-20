<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->hasOne(CourseUser::class)->where('user_id', auth()->user()->id);
    }

    public function scopeMy(Builder $query, $userId)
    {
        return $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function isBought()
    {
        $userCourses = CourseUser::where('user_id', auth()->user()->id)->pluck('course_id');

        return array_search($this->id, $userCourses->toArray()) !== false;
    }
}
