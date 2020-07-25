<?php

namespace App\Http\Services;

class LessonService
{
    public function maybeBuyLesson($lesson)
    {
        if (!$lesson->user) {
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

    public function maybeUploadFile($request, $path, $model)
    {
        if (!is_null($request->file('file'))) {
            return $model->files()->create([
                'path' => $request->file('file')->store($path),
                'name' => $request->file('file')->getClientOriginalName(),
            ]);
        }

        return null;
    }
}
