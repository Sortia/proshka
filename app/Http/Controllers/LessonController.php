<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\LessonRequest;
use App\Http\Requests\Student\ShowLessonRequest;
use App\Http\Services\LessonService;
use App\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    private LessonService $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    /**
     * Json список занятий с фильтром по курсу
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        return Lesson::where('course_id', $request->course_id)->get();
    }

    /**
     * Вьюха занятия
     *
     * @param Lesson $lesson
     * @param ShowLessonRequest $request
     * @return View
     */
    public function show(Lesson $lesson, ShowLessonRequest $request)
    {
        $lesson->load('videos', 'files', 'course', 'user');

        $lessonUser = $this->service->maybeBuyLesson($lesson);

        return view('public.lesson_show', compact('lesson', 'lessonUser'));
    }

    /**
     * Проставление студентом отметки "Выполнено"
     *
     * @param Lesson $lesson
     * @param LessonRequest $request
     * @return RedirectResponse
     */
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
}
