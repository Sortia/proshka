<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Services\TestService;
use App\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /** @var TestService  */
    private TestService $service;

    /**
     * TestController constructor.
     * @param TestService $service
     */
    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    /**
     * Возвращает html + инфу о тесте для добавления в модалку
     *
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function show(Lesson $lesson)
    {
        $lesson->load(['test.questions.answers', 'test.questions.files']);

        $html = $this->prepareLayout('manage.components.test', compact('lesson'));

        return response()->json(compact('html', 'lesson'));
    }

    /**
     * Сохранение теста
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $data = json_decode($request->data, true);
            $questions = $data['questions'];

            $test = $this->service->saveTest($data['lesson_id']);

            $this->service->deleteFilesIfNeed($test, $data['inline_files']);
            $this->service->deleteQuestionsIfNeed($test, $data['questions']);

            foreach ($questions as $questionData) {
                $question = $this->service->saveQuestion($test, $questionData);

                $this->service->saveQuestionFiles($question, $request->file("files_$questionData[index]"));
                $this->service->saveQuestionAnswers($question, $questionData['answers']);
            }
        });

        return $this->respondSuccess();
    }
}