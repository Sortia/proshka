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

    public function constraints()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_constraint', 'lesson_id', 'constraint_lesson_id');
    }

    public function available()
    {
        return $this->balanceAvailable() and $this->constraintAvailable();
    }

    private function balanceAvailable()
    {
        return $this->available_at <= $this->course->user->balance;
    }

    private function constraintAvailable()
    {
        $constraintLessonIds = $this->constraints->pluck('id');
        $rightLessonIds = $this->user->where('status', 'right')->pluck('lesson_id');
        $intersect = $constraintLessonIds->intersect($rightLessonIds);

        return $intersect->count() === $constraintLessonIds->count();
    }
}
