<?php

namespace App;

use App\Http\Services\LessonService;
use Exception;
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

    public function test()
    {
        return $this->hasOne(Test::class);
    }

    /**
     * Проверка на доступ к заданию для текущего студента
     *
     * @return bool
     */
    public function available(): bool
    {
        return $this->balanceAvailable() and $this->constraintAvailable();
    }

    /**
     * Проверка на необходимое количество баллов для выполнения задания
     *
     * @return bool
     */
    private function balanceAvailable(): bool
    {
        return $this->available_at <= $this->course->user->balance;
    }

    /**
     * Проверка на выполнение необходимых заданий
     *
     * @return bool
     */
    private function constraintAvailable(): bool
    {
        $constraintLessonIds = $this->constraints->pluck('id');
        $rightLessonIds = LessonUser::where('user_id', auth()->user()->id)->where('status', 'right')->pluck('lesson_id');
        $intersect = $constraintLessonIds->intersect($rightLessonIds);

        return $intersect->count() === $constraintLessonIds->count();
    }

    /**
     * Подстановка картинок в задание
     *
     * @return false|string
     * @throws Exception
     */
    public function printTask()
    {
        return (new LessonService())->printTask($this->task);
    }
}
