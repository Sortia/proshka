<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\BuyLessonRequest;
use App\Http\Requests\Student\LessonRequest;
use App\Http\Requests\Student\ShowLessonRequest;
use App\Http\Services\LessonService;
use App\Http\Services\QuestionService;
use App\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class LessonController extends Controller
{
    private LessonService $service;

    private QuestionService $questionService;

    public function __construct(LessonService $service, QuestionService $questionService)
    {
        $this->service = $service;
        $this->questionService = $questionService;
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
     * Покупка учеником задания
     *
     * @param Lesson $lesson
     * @return mixed
     * @throws Throwable
     */
    public function buy(Lesson $lesson, BuyLessonRequest $request)
    {
        $this->service->buyLesson($lesson);

        return $this->respondSuccess();
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

        return view('public.lesson_show', compact('lesson'));
    }

    /**
     * Проставление студентом отметки "Выполнено"
     *
     * @param Lesson $lesson
     * @param LessonRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function complete(Lesson $lesson, LessonRequest $request)
    {
        return DB::transaction(function () use ($lesson, $request) {
            $lesson->load('user');

            $lesson->user->update([
                'text' => $request->text,
                'status' => 'complete',
            ]);

            $this->service->maybeUploadFile($request, 'answers', $lesson->user);

            return redirect(route('course.show', ['course' => $lesson->course]));
        });
    }

    public function refuse(Lesson $lesson)
    {
        if ($lesson->user->status !== 'active') {
            return $this->respondError("Неверный статус занятия!", 444);
        }

        $this->questionService->setFine($lesson, $lesson->user->user);
        $lesson->user->update(['status' => 'wrong']);

        return compact('lesson');
    }
}
