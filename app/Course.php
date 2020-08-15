<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Course
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $direction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Direction $direction
 * @property-read Collection|\App\Lesson[] $lessons
 * @property-read int|null $lessons_count
 * @property-read CourseUser|null $user
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Course my($userId)
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course query()
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereDescription($value)
 * @method static Builder|Course whereDirectionId($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereName($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
