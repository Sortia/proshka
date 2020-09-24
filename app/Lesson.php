<?php

namespace App;

use App\Http\Services\LessonService;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Lesson
 *
 * @property int $id
 * @property int $course_id
 * @property string|null $name
 * @property string|null $description
 * @property int $order_number
 * @property int $cost
 * @property int $bonus
 * @property int $complexity
 * @property int $time
 * @property int $available_at
 * @property int $fine
 * @property string|null $text
 * @property string|null $task
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Lesson[] $constraints
 * @property-read int|null $constraints_count
 * @property-read Course $course
 * @property-read Collection|\App\File[] $files
 * @property-read int|null $files_count
 * @property-read Test|null $test
 * @property-read LessonUser|null $user
 * @property-read Collection|\App\Video[] $videos
 * @property-read int|null $videos_count
 * @method static Builder|Lesson newModelQuery()
 * @method static Builder|Lesson newQuery()
 * @method static Builder|Lesson query()
 * @method static Builder|Lesson whereAvailableAt($value)
 * @method static Builder|Lesson whereBonus($value)
 * @method static Builder|Lesson whereComplexity($value)
 * @method static Builder|Lesson whereCost($value)
 * @method static Builder|Lesson whereCourseId($value)
 * @method static Builder|Lesson whereCreatedAt($value)
 * @method static Builder|Lesson whereDescription($value)
 * @method static Builder|Lesson whereId($value)
 * @method static Builder|Lesson whereName($value)
 * @method static Builder|Lesson whereOrderNumber($value)
 * @method static Builder|Lesson whereTask($value)
 * @method static Builder|Lesson whereText($value)
 * @method static Builder|Lesson whereTime($value)
 * @method static Builder|Lesson whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
        'fine',
    ];

    public function lessons()
    {
        return $this->hasMany(LessonUser::class);
    }

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
        return $this->available_at <= auth()->user()->rating;
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
