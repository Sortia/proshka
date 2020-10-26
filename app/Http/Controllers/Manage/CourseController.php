<?php

namespace App\Http\Controllers\Manage;

use App\Course;
use App\Direction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::when($request->direction_id, function ($query) use ($request) {
            $query->where('direction_id', $request->direction_id);
        })->get();

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

    public function store(CourseRequest $request)
    {
        Course::updateOrCreate(['id' => $request->id], $request->all());

        return redirect(route('manage.course.index'));
    }

    public function destroy(Course $course)
    {
        if ($course->lessons->count()) {
            return redirect()->back()->withErrors(['Невозможно удалить курс']);
        }

        try {
            $course->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect(route('manage.course.index'));
    }
}
