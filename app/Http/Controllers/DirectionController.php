<?php

namespace App\Http\Controllers;

use App\Direction;
use App\CourseUser;
use Illuminate\View\View;

class DirectionController extends Controller
{
    /**
     * Страница со списком направлений
     *
     * @return View
     */
    public function index()
    {
        $directions = Direction::all();

        return view('public.direction', compact('directions'));
    }

    /**
     * Страница направления со списком его курсов
     *
     * @param Direction $direction
     * @return View
     */
    public function show(Direction $direction)
    {
        $direction->load('courses');

        return view('public.course', compact('direction'));
    }

}
