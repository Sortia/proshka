<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\LessonConstraint
 *
 * @property int $id
 * @property int $lesson_id
 * @property int $constraint_lesson_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Lesson $constraints
 * @property-read Lesson $lesson
 * @method static Builder|LessonConstraint newModelQuery()
 * @method static Builder|LessonConstraint newQuery()
 * @method static Builder|LessonConstraint query()
 * @method static Builder|LessonConstraint whereConstraintLessonId($value)
 * @method static Builder|LessonConstraint whereCreatedAt($value)
 * @method static Builder|LessonConstraint whereId($value)
 * @method static Builder|LessonConstraint whereLessonId($value)
 * @method static Builder|LessonConstraint whereUpdatedAt($value)
 * @mixin Eloquent
 */
class LessonConstraint extends Model
{
    protected $table = 'lesson_constraint';

    protected $fillable = [
        'constraint_lesson_id',
        'lesson_id'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function constraints()
    {
        return $this->belongsTo(Lesson::class, 'constraint_lesson_id');
    }

    public static function getBlock($constraints)
    {
        $constraints = implode(',', $constraints);

        $query = "
            select
                   lesson_id,
                   GROUP_CONCAT(constraint_lesson_id) as constraints
            from lesson_constraint
            group by lesson_id
            having constraints = '$constraints'
        ";

        return array_column((array)DB::select($query), 'lesson_id');
    }
}
