<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Список курсов с фильтром по направлению
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        return Course::when($request->direction_id, function ($query) use ($request) {
            $query->where('direction_id', $request->direction_id);
        })->get();
    }

    /**
     * Вьюха курса для студента
     *
     * @param Course $course
     * @return View
     */
//    public function show(Course $course)
//    {
//        return view('public.course_show', compact('course'));
//    }

    /**
     * Покупка курса
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function buy(Course $course)
    {
        CourseUser::on()->firstOrCreate([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id,
        ], ['balance' => 100]);

        return redirect(route('course.show', $course));
    }

    /**
     * Вьюха со списком курсов, купленных учеником
     *
     * @return View
     */
    public function my()
    {
        $courses = Course::my(auth()->user()->id)->get();

        return view('public.course_my', compact('courses'));
    }
}
