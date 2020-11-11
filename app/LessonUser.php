<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\LessonUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $lesson_id
 * @property int additional_point
 * @property string $status
 * @property string $comment
 * @property string|null $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|File[] $files
 * @property-read int|null $files_count
 * @property-read Lesson $lesson
 * @property-read User $user
 * @method static Builder|LessonUser newModelQuery()
 * @method static Builder|LessonUser newQuery()
 * @method static Builder|LessonUser query()
 * @method static Builder|LessonUser whereCreatedAt($value)
 * @method static Builder|LessonUser whereId($value)
 * @method static Builder|LessonUser whereLessonId($value)
 * @method static Builder|LessonUser whereStatus($value)
 * @method static Builder|LessonUser whereText($value)
 * @method static Builder|LessonUser whereUpdatedAt($value)
 * @method static Builder|LessonUser whereUserId($value)
 * @mixin Eloquent
 */
class LessonUser extends Model
{
    protected $table = 'lesson_user';

    protected $fillable = [
        'id',
        'user_id',
        'lesson_id',
        'status',
        'text',
        'additional_point',
        'comment',
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

//    public function getStatusAttribute($value)
//    {
//        return __(Str::ucfirst($value));
//    }
}
