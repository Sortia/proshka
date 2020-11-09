<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\LessonRequest;
use App\Http\Services\LessonService;
use App\Lesson;
use App\Direction;
use App\Models\LessonStatus;
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
        $courses = Course::when($request->direction_id, function ($query) use ($request) {
            $query->where('direction_id', $request->direction_id);
        })->get();

        $lessons = Lesson::with('constraints', 'test.questions')->when($request->course_id, function ($query) use ($request) {
            $query->where('course_id', $request->course_id);
        })->when($request->direction_id, function ($query) use ($courses) {
            $query->whereIn('course_id', $courses->pluck('id'));
        })->paginate(20);

        $directions = Direction::all();
        $statuses = LessonStatus::all();

        return view('manage.lesson_form', compact('directions', 'courses', 'lessons', 'statuses'));
    }

    public function show(Lesson $lesson)
    {
        $lesson = $lesson->load('files', 'course')->toArray();

        $lesson['task'] = $this->service->printTask($lesson['task']);

        return response()->json($lesson);
    }

    public function edit(Lesson $lesson)
    {
        $directions = Direction::all();

        return view('manage.lesson_form', compact('directions', 'lesson'));
    }

    public function store(LessonRequest $request)
    {
        $lesson = Lesson::updateOrCreate(['id' => $request->id], $request->toArray());

        $task = $this->service->replaceImages($request->task);

        $lesson->update(['task' => $task]);

        return redirect()->back();
    }

    public function destroy(Lesson $lesson)
    {
        try {
            $lesson->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

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
