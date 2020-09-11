<?php

namespace App\Http\Controllers;

use App\Direction;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $directions = Direction::all();

        return view('public.tasks', compact('directions'));
    }

    public function show(Request $request)
    {
        $lessonIds = $this->getLessonIds($request);

        $lessons = Lesson::with('course', 'user')->whereIn('id', $lessonIds)->get();

        if ($request->my_courses === 'true') {
            $lessons->filter(function (Lesson $lesson) {
                 return $lesson->available();
            });
        }

        $lessons->each(function (Lesson $lesson) {
            $lesson->is_available = $lesson->available();
        });

        return response()->json($lessons);

    }

    private function getLessonIds(Request  $request)
    {
        $directionCondition = $request->direction_id ? "and c.direction_id = $request->direction_id" : '';
        $typeCondition = $request->task_type === 'new' ? "and lu.status in ('active', 'rework')" : '';
        $myCondition = $request->my_courses === 'true' ? "and lu.id is not null" : '';

        $query =
            "select l.id as id,
                    l.name as name,
                    c.name as course,
                    l.complexity as complexity,
                    l.cost as cost,
                    l.bonus as bonus,
                    lu.status as status
             from lessons as l
                  left join lesson_user lu on l.id = lu.lesson_id
                  left join courses c on l.course_id = c.id
             where 1
                $directionCondition
                $typeCondition
                $myCondition
       ";

        $lessons = DB::select(DB::raw($query));

        return collect($lessons)->pluck('id');
    }
}
