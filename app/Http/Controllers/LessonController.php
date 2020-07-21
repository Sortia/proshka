<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\Student\LessonRequest;
use App\Http\Requests\Student\ShowLessonRequest;
use App\Lesson;
use Illuminate\Support\Facades\Response;

class LessonController extends Controller
{
    public function show(Lesson $lesson, ShowLessonRequest $request)
    {
        $lesson->load('videos', 'files', 'course', 'user');

        if (!$lesson->user) { // todo move to service class
            $lesson->user()->create([
                'user_id' => auth()->user()->id,
                'lesson_id' => $lesson->id,
                'status' => 'active'
            ]);

            $balance = $lesson->course->user->balance;

            $lesson->course->user->update(['balance' => $balance - $lesson->cost]);
            $lesson->load('user');
        }

        $lessonUser = $lesson->user;

        return view('public.lesson_show', compact('lesson', 'lessonUser'));
    }

    public function complete(Lesson $lesson, LessonRequest $request)
    {
        $lesson->load('user');

        $lesson->user->update([
            'text' => $request->text,
            'status' => 'complete',
        ]);

        if (!is_null($request->file('file'))) { // todo move to service
            $lesson->user->files()->create([
                'path' => $request->file('file')->store('answers'),
                'name' => $request->file('file')->getClientOriginalName(),
            ]);
        }

        return redirect(route('course.show', ['course' => $lesson->course]));
    }

    public function file(File $file)
    {
        return Response::download(storage_path('app/' . $file->path));
    }
}
