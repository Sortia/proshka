<?php

namespace App\Http\Controllers;

use App\Direction;
use App\Http\Requests\Student\AnswerRequest;
use App\Http\Requests\Teacher\CheckQuestionRequest;
use App\Http\Services\FileService;
use App\Http\Services\QuestionService;
use App\LessonUser;
use App\QuestionUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $questionUser = $this->service->storeStudentAnswer($request);
        $test = $questionUser->question->test;

        if ($this->service->allQuestionsCompleted($test, $questionUser->user)) {
            $this->service->setCompletedStatusForLessonUser($test->lesson->user);
        }

        if ($this->service->taskCompleteRight($test, $questionUser->user)) {
            $this->service->updateStatusForLessonUser($test->lesson, $questionUser->user, 'right');
        }

        return LessonUser::where('user_id', auth()->user()->id)->where('lesson_id', $test->lesson_id)->first();
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
        $lessonUserList = $this->service->filterTeacherList($request);

        $html = $this->prepareLayout('teacher.components.question_list', compact('lessonUserList'));

        return response()->json(compact('html'));
    }

    /**
     * Данные для заполнения модалки
     *
     * @param LessonUser $questionUser
     * @return JsonResponse
     */
    public function getLessonUserData(LessonUser $lessonUser)
    {
        $lessonUser->load('lesson.course.direction');

        $questionIds = $lessonUser->lesson->test->questions->pluck('id');

        $questionUserList = QuestionUser
            ::whereUserId($lessonUser->user_id)
            ->whereIn('question_id', $questionIds)
            ->with(
                'question.answers',
                'teacherFiles',
                'studentFiles',
                'question.test.lesson.course.direction'
            )->get();

        $html = $this->prepareLayout('teacher.components.answer', compact('questionUserList'));

        return response()->json(compact('questionUserList', 'html', 'lessonUser'));
    }

    /**
     * Проверка тестового задания учителем (смена статуса на right, wrong, rework)
     * + сохранение коммента и файлов (учитель)
     *
     * @param QuestionUser $questionUser
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function rightQuestion(QuestionUser $questionUser, Request $request)
    {
        return DB::transaction(function () use ($questionUser, $request) {
            $this->service->updateQuestionUser($questionUser, 'right', $request->comment);
            $this->service->saveFiles($questionUser, $request->file('files'));

            return $this->respondSuccess();
        });
    }

    /**
     * @param QuestionUser $questionUser
     * @param CheckQuestionRequest $request
     * @return mixed
     * @throws Throwable
     */
    public function reworkQuestion(QuestionUser $questionUser, Request $request)
    {
        return DB::transaction(function () use ($questionUser, $request) {
            $this->service->updateQuestionUser($questionUser, 'rework', $request->comment);
            $this->service->saveFiles($questionUser, $request->file('files'));

            $this->service->updateStatusForLessonUser($questionUser->question->test->lesson, $questionUser->user, 'active');

            return $this->respondSuccess();
        });
    }

    /**
     * Проставление отметки о верном выполниении задания
     *
     * @param LessonUser $lessonUser
     * @param CheckQuestionRequest $request
     * @return Response
     */
    public function rightLesson(LessonUser $lessonUser, CheckQuestionRequest $request)
    {
        if ($this->checkLessonState($lessonUser)) {
            return $this->respondError("Неверный статус!", 444);
        }

        if ($this->service->taskCompleteRight($lessonUser->lesson->test, $lessonUser->user)) {
            $this->service->updateStatusForLessonUser($lessonUser->lesson, $lessonUser->user, 'right');
            $this->service->processAddPoints($lessonUser, $lessonUser->user, $request->additional_points);

            return $this->respondSuccess();
        } else {
            return $this->respondError("Необходимо чтобы все задания были выполнены верно!", 444);
        }

    }

    /**
     * Проставление отметки о неверном выполнении задания
     *
     * @param LessonUser $lessonUser
     * @param CheckQuestionRequest $request
     * @return Response
     */
    public function wrongLesson(LessonUser $lessonUser, CheckQuestionRequest $request)
    {
        if ($this->checkLessonState($lessonUser)) {
            return $this->respondError("Неверный статус!", 444);
        }

        $this->service->setFine($lessonUser->lesson, $lessonUser->user);
        $this->service->updateStatusForLessonUser($lessonUser->lesson, $lessonUser->user, 'wrong');

        return $this->respondSuccess();
    }

    private function checkLessonState(LessonUser $lessonUser)
    {
        return $lessonUser->status !== 'complete';
    }
}
