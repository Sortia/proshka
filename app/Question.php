<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Question
 *
 * @property int $id
 * @property string $type
 * @property int $accept_file
 * @property string $question
 * @property int $test_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Answer[] $answers
 * @property-read int|null $answers_count
 * @property-read Collection|File[] $files
 * @property-read int|null $files_count
 * @property-read Test $test
 * @property-read QuestionUser|null $user
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereAcceptFile($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereTestId($value)
 * @method static Builder|Question whereType($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Question extends Model
{
    protected $fillable = [
        'id',
        'type',
        'accept_file',
        'question',
        'test_id',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function user()
    {
        return $this->hasOne(QuestionUser::class)->where('user_id', auth()->user()->id);
    }

    public function rightAnswer()
    {
        return $this->hasOne(Answer::class)->where('is_right', 1);
    }

    public function isActive()
    {
        if (is_null($this->user)) {
            return true;
        }

        if ($this->user->status === 'rework') {
            return true;
        }

        return false;
    }
}
