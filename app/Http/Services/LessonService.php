<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            return FileService::save($model, $request->file('file'), $path);
        }

        return null;
    }

    public function replaceImages($task)
    {
        preg_match('/<img[^>]+>/', $task, $imageTags);

        foreach ($imageTags as $tag) {
            $imageName = Str::random(32);

            Storage::put("images/$imageName" , str_replace('<img', '<img width="100%"', $tag));

            $task = str_ireplace($tag, "{!! Storage::get('images/$imageName')!!}", $task);
        }

        return $task;
    }

    /**
     * Подстановка картинок в задание
     *
     * @throws Exception
     */
    public function printTask(?string $task) {
        $php = Blade::compileString($task);
        $obLevel = ob_get_level();
        ob_start();

        try {
            eval('?' . '>' . $php);
        } catch (Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    }
}
