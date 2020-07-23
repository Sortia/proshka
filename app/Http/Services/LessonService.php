<?php

namespace App\Http\Services;

class LessonService
{
    public function maybeBuyLesson($lesson)
    {
        if (!$lesson->user) { // todo move to service class
            $lesson->user()->create([
                'user_id' => auth()->user()->id,
                'lesson_id' => $lesson->id,
                'status' => 'active'
            ]);

            $balance = $lesson->course->user->balance - $lesson->cost;

            $lesson->course->user->update(['balance' => $balance]);
            $lesson->load('user');
        }

        return $lesson->user;
    }

    public function maybeUploadFile($request, $lesson)
    {
        if (!is_null($request->file('file'))) { // todo move to service
            $lesson->user->files()->create([
                'path' => $request->file('file')->store('answers'),
                'name' => $request->file('file')->getClientOriginalName(),
            ]);
        }
    }
}
