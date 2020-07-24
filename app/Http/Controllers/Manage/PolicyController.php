<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Direction;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\LessonConstraint;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function store(Request $request)
    {
        LessonConstraint::whereIn('lesson_id', $request->lessons)->delete();

        foreach ($request->lessons as $lessonId) {
            foreach ($request->constraints as $constraintId) {
                LessonConstraint::create([ // todo optimize
                    'lesson_id' => $lessonId,
                    'constraint_lesson_id' => $constraintId
                ]);
            }
        }

        return $this->respondSuccess();
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('course.lessons', 'constraints');

        $directions = Direction::all();
        $courses = Course::where('direction_id', $lesson->course->direction_id)->get();
        $courseLessons = Lesson::where('course_id', $lesson->course_id)->get();
        $constraints = $lesson->constraints->pluck('id');
        $lessons = LessonConstraint::getBlock($constraints->toArray());
        $constraintCourse = $lesson->constraints->first()->course ?? [];

        if ($constraintCourse)
            $constraintCourse->load('lessons');


        return response()->json(compact(
            'lessons',
            'constraints',
            'lesson',
            'directions',
            'courses',
            'courseLessons',
            'constraintCourse'
        ));
    }
}
