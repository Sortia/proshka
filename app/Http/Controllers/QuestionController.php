<?php

namespace App\Http\Controllers;

use App\Direction;
use App\Http\Requests\Student\AnswerRequest;
use App\Http\Requests\Teacher\CheckQuestionRequest;
use App\Http\Services\FileService;
use App\Http\Services\QuestionService;
use App\LessonUser;
use App\QuestionUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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

//        if ($this->service->taskCompleteRight($test, $questionUser->user)) {
//            $this->service->updateStatusForLessonUser($test->lesson, $questionUser->user, 'right');
//        }

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

        $this->saveQuestions($request, 'right');
        $this->service->updateStatusForLessonUser($lessonUser->lesson, $lessonUser->user, 'right');
        $this->service->processAddPoints($lessonUser, $request);

        return $this->respondSuccess();
    }

    /**
     * Проставление отметки о неверном выполнении задания
     *
     * @param LessonUser $lessonUser
     * @param Request $request
     * @return Response
     */
    public function wrongLesson(LessonUser $lessonUser, Request $request)
    {
        if ($this->checkLessonState($lessonUser)) {
            return $this->respondError("Неверный статус!", 444);
        }

        $this->saveQuestions($request, 'wrong');
        $this->service->setFine($lessonUser->lesson, $lessonUser->user);
        $this->service->updateStatusForLessonUser($lessonUser->lesson, $lessonUser->user, 'wrong');

        return $this->respondSuccess();
    }

    /**
     * Отправка задания на доработку
     *
     * @param LessonUser $lessonUser
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function reworkLesson(LessonUser $lessonUser, Request $request)
    {
        if ($this->checkLessonState($lessonUser)) {
            return $this->respondError("Неверный статус!", 444);
        }

        $this->saveQuestions($request, 'rework');
        $this->service->updateStatusForLessonUser($lessonUser->lesson, $lessonUser->user, 'active');

        return $this->respondSuccess();
    }

    /**
     * @param Request $request
     * @param string $status
     */
    private function saveQuestions(Request $request, string $status)
    {
        $questions = json_decode($request->questions, true);

        foreach ($questions as $question) {
            $questionUser = QuestionUser::find($question['id']);
            $question['status'] = $status;

            $this->service->updateQuestionUser($questionUser, $question);
            $this->service->saveFiles($questionUser, $request->file("files_" . $questionUser->id));
        }
    }

    private function checkLessonState(LessonUser $lessonUser)
    {
        return $lessonUser->status !== 'complete';
    }
}
