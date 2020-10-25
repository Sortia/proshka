<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Answer
 *
 * @property int $id
 * @property string $text
 * @property int $is_right
 * @property int $question_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Question $question
 * @method static Builder|Answer newModelQuery()
 * @method static Builder|Answer newQuery()
 * @method static Builder|Answer query()
 * @method static Builder|Answer whereCreatedAt($value)
 * @method static Builder|Answer whereId($value)
 * @method static Builder|Answer whereIsRight($value)
 * @method static Builder|Answer whereQuestionId($value)
 * @method static Builder|Answer whereText($value)
 * @method static Builder|Answer whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Answer extends Model
{
    protected $fillable = [
        'text',
        'is_right',
        'question_id',
        'order_number',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
