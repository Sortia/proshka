<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
