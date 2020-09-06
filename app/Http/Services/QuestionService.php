<?php


namespace App\Http\Services;


use App\Constants\QuestionUserStatus;
use App\Lesson;
use App\LessonUser;
use App\QuestionUser;
use App\Test;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class QuestionService
{
    private FileService $fileService;

    public function construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Фильтрация списка учителя
     *
     * @param Request $request
     * @return mixed
     */
    public function filterTeacherList(Request $request)
    {
        return QuestionUser::with('question.test.lesson.course.direction')
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
    }

    /**
     * Сохранение ответа ученика
     *
     * @param Request $request
     * @throws Throwable
     */
    public function storeStudentAnswer(Request $request)
    {
        DB::transaction(function () use ($request) {
            $questionUser = QuestionUser::updateOrCreate([
                'id' => $request->question_user_id
            ], [
                'question_id' => $request->question_id,
                'user_id' => Auth::user()->id,
                'answer_id' => $request->answer_id,
                'text' => $request->text,
                'status' => QuestionUserStatus::COMPLETE,
            ]);

            foreach ($request->file('files') ?? [] as $file) {
                $this->fileService->save($questionUser, $file, 'user_answers');
            }
        });
    }

    /**
     * Сохранение файлов, прикрепленных учителем при проверке задания
     *
     * @param QuestionUser $questionUser
     * @param array|null $files
     */
    public function saveFiles(QuestionUser $questionUser, ?array $files)
    {
        foreach ($files ?? [] as $file) {
            $this->fileService->save($questionUser, $file, 'teacher_comment');
        }
    }

    /**
     * Проставление статуса и комментария
     *
     * @param QuestionUser $questionUser
     * @param string $status
     * @param $comment
     */
    public function updateQuestionUser(QuestionUser $questionUser, string $status, ?string $comment)
    {
        $questionUser->update([
            'status' => $status,
            'comment' => $comment,
        ]);
    }

    /**
     * Начисление баллов за правильное выполнение задания $lessonId пользователю $userId
     *
     * @param Lesson $test
     * @param User $user
     */
    public function processAddPoints(Lesson $lesson, User $user, $additionalPoints)
    {
        if (is_null($additionalPoints)) {
            $additionalPoints = 0;
        }

        $user->update([
            'rating' => $user->rating + $lesson->bonus + $additionalPoints,
            'points' => $user->points + $lesson->bonus + $additionalPoints,
        ]);
    }

    /**
     * Обновление статуса занятия студента
     *
     * @param LessonUser $lessonUser
     */
    public function setRightStatusForLessonUser(Lesson $lesson, User $user)
    {
        LessonUser::where('lesson_id', $lesson->id)
            ->where('user_id', $user->id)
            ->update(['status' => 'right']);
    }

    /**
     * Вернет true если все задания
     *
     * @param Test $test
     * @param User $user
     * @return bool
     */
    public function taskCompleteRight(Test $test, User $user)
    {
        $countQuestionsInTest = $test->getCountQuestions();
        $countRightAnswersInTest = $this->getCountRightAnswers($test, $user);

        return $countRightAnswersInTest === $countQuestionsInTest;
    }

    /**
     * Подсчет числа правильных ответов в тесте $testId для ученика $userId
     *
     * @param Test $test
     * @param User $user
     * @return int
     */
    private function getCountRightAnswers(Test $test, User $user)
    {
        return QuestionUser::where('status', 'right')
            ->where('user_id', $user->id)
            ->with(['question' => function (Builder $query) use ($test) {
                $query->where('test_id', $test->id);
            }])->count();
    }
}
