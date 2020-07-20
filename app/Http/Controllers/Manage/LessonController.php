<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Direction;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $lessons = Lesson::all();

        return view('manage.lesson', compact('lessons'));
    }

    public function create()
    {
        $test = [
            'course_id' => 1,
            'name' => 'first lesson',
            'description' => 'lesson description',
            'order_number' => 1,
            'cost' => 5,
            'bonus' => 10,
            'fine' => 7,
//            'text' => 1,
//            'video' => 1,
//            'file' => 1,
        ];

        Lesson::updateOrCreate(['id' => null], $test);

        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions'));
    }

    public function edit(Lesson $lesson)
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions', 'lesson'));
    }

    public function store(Request $request)
    {
//        $test = [
//            'course_id' => 1,
//            'name' => 'first lesson',
//            'description' => 'lesson description',
//            'order_number' => 1,
//            'cost' => 5,
//            'bonus' => 10,
//            'fine' => 7,
//            'text' => 1,
//            'video' => 1,
//            'file' => 1,
//        ];

        Lesson::updateOrCreate(['id' => $request->id], $request->all());

        return redirect(route('manage.lesson.index'));
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect(route('manage.lesson.index'));
    }
}
