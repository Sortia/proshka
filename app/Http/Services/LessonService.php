<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LessonService
{
    /**
     * Покупка занятия, если оно еще не куплено
     *
     * @param $lesson
     * @return mixed
     */
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

    /**
     * Обработка загрузки файла (если этот файл был загружен)
     *
     * @param Request $request
     * @param string $path
     * @param Model $model
     * @return null|Model
     */
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
