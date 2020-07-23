<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $task = Lesson::whereKey($request->lesson_id)->value('task');

        return response()->json(print_task($task));
    }

    public function store(Request $request)
    {
        preg_match('/<img[^>]+>/', $request->task, $imageTags);

        foreach ($imageTags as $tag) {
            $imageName = Str::random(32);

            Storage::put("images/$imageName" , str_replace('<img', '<img width="100%"', $tag));

            $request->task = str_ireplace($tag, "{!! Storage::get('images/$imageName')!!}", $request->task);
        }

        Lesson::whereKey($request->lesson_id)->update(['task' => $request->task]);

        return $this->respondSuccess();
    }
}
