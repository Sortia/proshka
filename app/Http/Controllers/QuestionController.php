<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Constants\QuestionUserStatus;
use App\Direction;
use App\Http\Requests\Student\AnswerRequest;
use App\Http\Services\FileService;
use App\QuestionUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionController extends Controller
{
    // todo написание автоматических тестов

    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Сохранение ответа на тест (ученик)
     *
     * @param Request $request
     * @return Response
     */
    public function store(AnswerRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $questionUser = QuestionUser::updateOrCreate([
                'id' => $request->question_user_id
            ],[
                'question_id' => $request->question_id,
                'user_id' => Auth::user()->id,
                'answer_id' => $request->answer_id,
                'text' => $request->text,
                'status' => QuestionUserStatus::COMPLETE,
            ]);

            foreach ($request->file('files') ?? [] as $file) {
                $this->fileService->save($questionUser, $file, 'user_answers');
            }

            return $this->respondSuccess();
        });
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
        /** @var QuestionUser $answers */
        $questionUserList = QuestionUser::with('question.test.lesson.course.direction')
            ->whereHas('question.test.lesson', function ($query) use ($request) { // фильтрация по курсу
                $query->where('course_id', $request->course_id);
            })
            ->whereHas('user', function ($query) use ($request) { // фильтрация по имени студента
                $query->where('name', 'like', "%$request->search%");
            })
            ->when($request->status === 'not_verified', function (Builder $query) { // фильтрация по статусу (выполненные)
                $query->where('status', 'complete');
            })
            ->when($request->status === 'verified', function (Builder $query) { // фильтрация по статусу (не выполненные)
                $query->where('status', '<>', 'complete');
            })
            ->{$request->date_sort}() // сортировка по дате: oldest() or latest()
            ->paginate(15);

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
     */
    public function checkQuestion(QuestionUser $questionUser, string $status, Request $request)
    {
        return DB::transaction(function () use ($questionUser, $status, $request) {
            $questionUser->update([
                'comment' => $request->comment,
                'status' => $status,
            ]);

            foreach ($request->file('files') ?? [] as $file) {
                $this->fileService->save($questionUser, $file, 'teacher_comment');
            }

            return $this->respondSuccess();
        });
    }
}
