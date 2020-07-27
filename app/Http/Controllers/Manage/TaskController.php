<?php
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Services\TaskService;
use App\Lesson;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $task = Lesson::whereKey($request->lesson_id)->value('task');

        return response()->json($this->service->print($task));
    }

    public function store(Request $request)
    {
        $task = $this->service->replaceImages($request->task);

        Lesson::whereKey($request->lesson_id)->update(['task' => $task]);

        return $this->respondSuccess();
    }
}
