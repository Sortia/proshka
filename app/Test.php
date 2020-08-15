<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Test
 *
 * @property int $id
 * @property int $lesson_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Lesson $lesson
 * @property-read Collection|\App\Question[] $questions
 * @property-read int|null $questions_count
 * @method static Builder|Test newModelQuery()
 * @method static Builder|Test newQuery()
 * @method static Builder|Test query()
 * @method static Builder|Test whereCreatedAt($value)
 * @method static Builder|Test whereId($value)
 * @method static Builder|Test whereLessonId($value)
 * @method static Builder|Test whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
