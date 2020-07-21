<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Direction;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::all();

        return view('manage.lesson', compact('lessons'));
    }

    public function create()
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions'));
    }

    public function edit(Lesson $lesson)
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions', 'lesson'));
    }

    public function store(Request $request) // todo страница создания урока
    {
        Lesson::updateOrCreate(['id' => $request->id], $request->all());

        return redirect(route('manage.lesson.index'));
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect(route('manage.lesson.index'));
    }
}
