<?php

namespace App\Http\Services;

use App\Course;
use App\CourseUser;
use App\Lesson;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class LessonService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function saveFiles(Lesson $lesson, ?array $files): void
    {
        if (!is_null($files)) {
            foreach ($files as $file) {
                $this->fileService->save($lesson, $file, 'lessons');
            }
        }
    }

    public function deleteFilesIfNeed(Lesson $lesson, ?array $inlineFiles): void
    {
        $files = $lesson->files;
        $inlineFiles = [];

        foreach ($files ?? [] as $file) {
            if (!in_array($file->id, array_column($inlineFiles, 'id'))) {
                $this->fileService->delete($file);
            }
        }
    }
    /**
     * Покупка занятия, если оно еще не куплено
     *
     * @param $lesson
     * @return mixed
     * @throws Throwable
     */
    public function buyLesson($lesson)
    {
        return DB::transaction(function () use ($lesson) {
            if (!$lesson->user) {
                $lessonUser = $lesson->user()->create([
                    'user_id' => auth()->user()->id,
                    'lesson_id' => $lesson->id,
                    'status' => 'active'
                ]);

                $points = $lessonUser->user->points - $lesson->cost;

                $lessonUser->user->update(['points' => $points]);
                $lesson->load('user');
            }
        });
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

            Storage::put("images/$imageName" , $tag);

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

    public function courseNotBought(Course $course, User $user)
    {
        return CourseUser::whereCourseId($course->id)->whereUserId($user->id)->doesntExist();
    }

    public function buyCourse(Course $course, User $user)
    {
        return CourseUser::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'balance' => 100
        ]);
    }
}
