<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Direction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
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
//        if (Gate::denies('is_methodist')) {
//            return abort(404);
//        }

        $courses = Course::all();

        return view('manage.course', compact('courses'));
    }

    public function create()
    {
        $directions = Direction::all();

        return view('manage.course_form', compact('directions'));
    }

    public function edit(Course $course)
    {
        $directions = Direction::all();

        return view('manage.course_form', compact('directions', 'course'));
    }

    public function store(Request $request)
    {
        Course::updateOrCreate(['id' => $request->id], $request->all());

        return redirect(route('manage.course.index'));
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect(route('manage.course.index'));
    }
}
