<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Constants\QuestionUserStatus;
use App\Direction;
use App\Http\Requests\Student\AnswerRequest;
use App\Http\Requests\Teacher\CheckQuestionRequest;
use App\Http\Services\FileService;
use App\Http\Services\QuestionService;
use App\QuestionUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class QuestionController extends Controller
{
    private FileService $fileService;

    private QuestionService $service;

    public function __construct(FileService $fileService, QuestionService $service)
    {
        $this->fileService = $fileService;
        $this->service = $service;
    }

    /**
     * Сохранение ответа на тест (ученик)
     *
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function store(AnswerRequest $request)
    {
        $this->service->storeStudentAnswer($request);

        return $this->respondSuccess();
    }

    /**
     * Страница учителя для проверки заданий
     *
     * @return View
     */
    public function teacherShow()
    {
        $directions = Direction::all();

        return view('teacher.test_show', compact('directions'));
    }

    /**
     * Фильтрация списка учителя
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filterList(Request $request)
    {
        $questionUserList = $this->service->filterTeacherList($request);

        $html = $this->prepareLayout('teacher.components.question_list', compact('questionUserList'));

        return response()->json(compact('html'));
    }

    /**
     * Данные для заполнения модалки
     *
     * @param QuestionUser $questionUser
     * @return JsonResponse
     */
    public function getQuestionUserData(QuestionUser $questionUser)
    {
        $questionUser->load('question.answers', 'teacherFiles', 'studentFiles', 'question.test.lesson.course.direction');

        $html = $this->prepareLayout('teacher.components.answer', compact('questionUser'));

        return response()->json(compact('questionUser', 'html'));
    }

    /**
     * Проверка тестового задания учителем (смена статуса на right, wrong, rework)
     * + сохранение коммента и файлов
     *
     * @param QuestionUser $questionUser
     * @param string $status
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function checkQuestion(QuestionUser $questionUser, string $status, CheckQuestionRequest $request)
    {
        dd($request->all());
        return DB::transaction(function () use ($questionUser, $status, $request) {
            $this->service->updateQuestionUser($questionUser, $request->status, $request->comment);
            $this->service->saveFiles($questionUser, $request->file('files'));

            $test = $questionUser->question->test;
            $user = $questionUser->user;

            if ($this->service->taskCompleteRight($test, $user)) {
                $this->service->processAddPoints($test->lesson, $user, $request->additional_points);
                $this->service->setRightStatusForLessonUser($test->lesson, $user);
            }

            return $this->respondSuccess();
        });
    }
}
