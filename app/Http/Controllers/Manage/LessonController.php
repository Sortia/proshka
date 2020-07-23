<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Direction;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $lessons = Lesson::on()->where('course_id', $request->course_id)->get();
        $directions = Direction::all();
        $courses = Course::all();

        return view('manage.lesson_form', compact('directions', 'courses', 'lessons'));
    }

    public function edit(Lesson $lesson)
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions', 'lesson'));
    }

    public function store(Request $request)
    {
        Lesson::updateOrCreate(['id' => $request->id], $request->all());

        return redirect()->back();
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect(route('manage.lesson.index'));
    }
}
