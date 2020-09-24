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
        $directions = Direction::with('courses')->get();

        return view('public.direction', compact('directions'));
    }
}
