<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\TestShowRequest;
use App\Test;
use Illuminate\View\View;

class TestController extends Controller
{
    /**
     * Страница прохождения теста по занятию
     *
     * @param Test $test
     * @param TestShowRequest $request
     * @return View
     */
    public function show(Test $test, TestShowRequest $request)
    {
        $test->load(['questions.answers', 'questions.files']);

        return view('public.test_show', compact('test'));
    }
}
