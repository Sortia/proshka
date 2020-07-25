<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\Student\LessonRequest;
use App\Http\Requests\Student\ShowLessonRequest;
use App\Http\Services\LessonService;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LessonController extends Controller
{
    private LessonService $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        return Lesson::where('course_id', $request->course_id)->get();
    }

    public function show(Lesson $lesson, ShowLessonRequest $request)
    {
        $lesson->load('videos', 'files', 'course', 'user');

        $lessonUser = $this->service->maybeBuyLesson($lesson);

        return view('public.lesson_show', compact('lesson', 'lessonUser'));
    }

    public function complete(Lesson $lesson, LessonRequest $request)
    {
        $lesson->load('user');

        $lesson->user->update([
            'text' => $request->text,
            'status' => 'complete',
        ]);

        $this->service->maybeUploadFile($request, 'answers', $lesson->user);

        return redirect(route('course.show', ['course' => $lesson->course]));
    }

    public function file(File $file)
    {
        return Response::download(storage_path('app/' . $file->path));
    }
}
