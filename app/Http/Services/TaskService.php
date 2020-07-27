<?php


namespace App\Http\Services;


use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskService
{
    /**
     * Замена картинок, их подключением
     *
     * @param $task
     * @return string|string[]
     */
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
    public function print(?string $task) {
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
