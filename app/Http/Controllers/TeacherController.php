<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\Http\Requests\Teacher\EvaluateLessonRequest;
use App\LessonUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Вьюха со списком занятий отправленных на проверку
     *
     * @return View
     */
    public function index()
    {
        $userLessons = LessonUser::where('status', 'complete')->get();

        return view('public.lessons_complete', compact('userLessons'));
    }

    /**
     * Проставление отметки о неверном выполнении задания
     *
     * @param LessonUser $lessonUser
     * @param EvaluateLessonRequest $request
     * @return RedirectResponse
     */
    public function wrong(LessonUser $lessonUser, EvaluateLessonRequest $request)
    {
        $lessonUser->update(['status' => 'wrong']);

        return redirect(route('teacher.lesson.completed'));
    }

    /**
     * Проставление отметки о верном выполнении задания
     *
     * @param LessonUser $lessonUser
     * @param EvaluateLessonRequest $request
     * @return RedirectResponse
     */
    public function right(LessonUser $lessonUser, EvaluateLessonRequest $request)
    {
        return DB::transaction(function () use ($lessonUser, $request) {
            $lessonUser->update(['status' => 'right']);

            $courseUser = CourseUser::on()
                ->where('user_id', $lessonUser->user_id)
                ->where('course_id', $lessonUser->lesson->course_id)
                ->first();

            $courseUser->update(['balance' => $courseUser->balance + $lessonUser->lesson->bonus]);

            return redirect(route('teacher.lesson.completed'));
        });
    }
}
