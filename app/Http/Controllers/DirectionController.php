<?php

namespace App\Http\Controllers;

use App\Direction;
use App\CourseUser;

class DirectionController extends Controller
{
    public function index()
    {
        $directions = Direction::all();

        return view('public.direction', compact('directions'));
    }

    public function show(Direction $direction)
    {
        return view('public.direction_show', compact('direction'));
    }

}
