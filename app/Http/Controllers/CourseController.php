<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseUser;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        return view('public.course_show', compact('course'));
    }

    public function buy(Course $course)
    {
        CourseUser::on()->firstOrCreate([
            'user_id' => auth()->user()->id,
            'course_id' => $course->id,
        ], ['balance' => 100]);

        return redirect(route('course.show', $course));
    }

    public function my()
    {
        $courses = Course::my(auth()->user()->id)->get();

        return view('public.course_my', compact('courses'));
    }
}
