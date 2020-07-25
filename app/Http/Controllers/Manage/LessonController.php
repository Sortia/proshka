<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\LessonRequest;
use App\Http\Services\LessonService;
use App\Lesson;
use App\Direction;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private LessonService $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $lessons = Lesson::with('constraints')->where('course_id', $request->course_id)->get();
        $directions = Direction::all();
        $courses = Course::where('direction_id', $request->direction_id)->get();

        return view('manage.lesson_form', compact('directions', 'courses', 'lessons'));
    }

    public function show(Lesson $lesson)
    {
        return $lesson->load('files');
    }

    public function edit(Lesson $lesson)
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions', 'lesson'));
    }

    public function store(LessonRequest $request)
    {
        Lesson::updateOrCreate(['id' => $request->id], $request->toArray());

        return redirect()->back();
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return $this->respondSuccess();
    }

    public function uploadFile(Lesson $lesson, Request $request)
    {
        $file = $this->service->maybeUploadFile($request, 'lessons', $lesson);

        if ($file) {
            return $file;
        } else {
            return $this->respondError('Ошибка при загрузке файла.');
        }
    }
}
