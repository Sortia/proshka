<?php

namespace App\Http\Controllers\Manage;

use App\Direction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    public function index()
    {
        $directions = Direction::all();

        return view('manage.direction', compact('directions'));
    }

    public function create()
    {
        return view('manage.direction_form');
    }

    public function edit(Direction $direction)
    {
        return view('manage.direction_form', compact('direction'));
    }

    public function store(Request $request)
    {
        Direction::updateOrCreate(['id' => $request->id], $request->all());

        return redirect(route('manage.direction.index'));
    }

    public function destroy(Direction $direction)
    {
        $direction->delete();

        return redirect(route('manage.direction.index'));
    }
}
