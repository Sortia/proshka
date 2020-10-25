<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\QuestionUser
 *
 * @property int $id
 * @property int $question_id
 * @property int $user_id
 * @property int|null $answer_id
 * @property string|null $text
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $comment
 * @property-read Answer|null $answer
 * @property-read Collection|File[] $files
 * @property-read int|null $files_count
 * @property-read Question $question
 * @property-read Collection|File[] $studentFiles
 * @property-read int|null $student_files_count
 * @property-read Collection|File[] $teacherFiles
 * @property-read int|null $teacher_files_count
 * @property-read User $user
 * @method static Builder|QuestionUser newModelQuery()
 * @method static Builder|QuestionUser newQuery()
 * @method static Builder|QuestionUser query()
 * @method static Builder|QuestionUser whereAnswerId($value)
 * @method static Builder|QuestionUser whereComment($value)
 * @method static Builder|QuestionUser whereCreatedAt($value)
 * @method static Builder|QuestionUser whereId($value)
 * @method static Builder|QuestionUser whereQuestionId($value)
 * @method static Builder|QuestionUser whereStatus($value)
 * @method static Builder|QuestionUser whereText($value)
 * @method static Builder|QuestionUser whereUpdatedAt($value)
 * @method static Builder|QuestionUser whereUserId($value)
 * @method static Builder whereTest(Test $test)
 * @mixin Eloquent
 */
class QuestionUser extends Model
{
    protected $table = 'question_user';

    protected $fillable = [
        'question_id',
        'user_id',
        'answer_id',
        'text',
        'status',
        'comment',
    ];

    protected $casts = [
        'answer_id' => 'array'
    ];

    protected $attributes = [
        'answer_id' => '[]'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function studentFiles()
    {
        return $this->morphMany(File::class, 'fileable')->where('path', 'like', 'user_answers%');
    }

    public function teacherFiles()
    {
        return $this->morphMany(File::class, 'fileable')->where('path', 'like', 'teacher_comment%');
    }

}
