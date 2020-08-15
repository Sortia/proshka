<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\CourseUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CourseUser newModelQuery()
 * @method static Builder|CourseUser newQuery()
 * @method static Builder|CourseUser query()
 * @method static Builder|CourseUser whereBalance($value)
 * @method static Builder|CourseUser whereCourseId($value)
 * @method static Builder|CourseUser whereCreatedAt($value)
 * @method static Builder|CourseUser whereId($value)
 * @method static Builder|CourseUser whereUpdatedAt($value)
 * @method static Builder|CourseUser whereUserId($value)
 * @mixin Eloquent
 */
class CourseUser extends Model
{
    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'balance',
    ];
}
