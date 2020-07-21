<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\Http\Requests\Teacher\EvaluateLessonRequest;
use App\LessonUser;

class TeacherController extends Controller
{
    public function index()
    {
        $userLessons = LessonUser::where('status', 'complete')->get();

        return view('public.lessons_complete', compact('userLessons'));
    }

    public function show(LessonUser $lessonUser)
    {
        $lessonUser->load('lesson.videos', 'lesson.files', 'lesson.course', 'files');

        $lesson = $lessonUser->lesson;

        return view('public.lesson_show', compact('lesson', 'lessonUser'));
    }

    public function wrong(LessonUser $lessonUser, EvaluateLessonRequest $request)
    {
        $lessonUser->update(['status' => 'wrong']);

        return redirect(route('teacher.lesson.completed'));
    }

    public function right(LessonUser $lessonUser, EvaluateLessonRequest $request)
    {
        $lessonUser->update(['status' => 'right']);

        $courseUser = CourseUser::on() // todo move to service
            ->where('user_id', $lessonUser->user_id)
            ->where('course_id', $lessonUser->lesson->course_id)
            ->first();

        $courseUser->update(['balance' => $courseUser->balance + $lessonUser->lesson->bonus]);

        return redirect(route('teacher.lesson.completed'));
    }
}
