<?php


namespace App\Http\Services;


use App\Constants\QuestionUserStatus;
use App\Lesson;
use App\LessonUser;
use App\Question;
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
    /**
     * Фильтрация списка учителя
     *
     * @param Request $request
     * @return mixed
     */
    public function filterTeacherList(Request $request)
    {
        return LessonUser::with('lesson.course.direction', 'user')
            ->whereHas('lesson.course', function ($query) use ($request) { // фильтрация по курсу
                $query->where('id', $request->course_id);
            })
            ->whereHas('user', function ($query) use ($request) { // фильтрация по имени студента
                $query->where('name', 'like', "%$request->search%");
            })
            ->when($request->status === 'not_verified', function (Builder $query) { // фильтрация по статусу (выполненные)
                $query->where('status', 'complete');
            })
            ->when($request->status === 'verified', function (Builder $query) { // фильтрация по статусу (не выполненные)
                $query->whereIn('status', ['right', 'wrong']);
            })
            ->{$request->date_sort}() // сортировка по дате: oldest() or latest()
            ->paginate(15);
    }

    /**
     * Сохранение ответа ученика
     *
     * @param Request $request
     * @return QuestionUser
     * @throws Throwable
     */
    public function storeStudentAnswer(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $questionUser = QuestionUser::firstOrNew([
                'id' => $request->question_user_id
            ], [
                'question_id' => $request->question_id,
                'user_id' => Auth::user()->id,
                'answer_id' => $request->answer_id,
                'text' => $request->text,
                'status' => QuestionUserStatus::COMPLETE,
            ]);

            /** Если это задание с выбором варианта ответа и ответ выбран правильно */
            if ($questionUser->question->type === 'select' && $questionUser->question->rightAnswer) {
                if ($questionUser->question->rightAnswer->id == $request->answer_id) {
                    $questionUser->status = QuestionUserStatus::RIGHT;
                } else {
                    $questionUser->status = QuestionUserStatus::WRONG;
                }
            }

            $questionUser->save();

            $fileService = new FileService();

            foreach ($request->file('files') ?? [] as $file) {
                $fileService->save($questionUser, $file, 'user_answers');
            }

            return $questionUser;
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
        $fileService = new FileService();

        foreach ($files ?? [] as $file) {
            $fileService->save($questionUser, $file, 'teacher_comment');
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
    public function processAddPoints(LessonUser $lessonUser, User $user, $additionalPoints)
    {
        if (is_null($additionalPoints)) {
            $additionalPoints = 0;
        }

        $user->update([
            'rating' => $user->rating + $lessonUser->lesson->bonus + $additionalPoints,
            'points' => $user->points + $lessonUser->lesson->bonus + $additionalPoints,
        ]);

        $lessonUser->update(['additional_point' => $additionalPoints]);
    }

    /**
     * Проставление штрафа за невыполнение задания
     *
     * @param Lesson $lesson
     * @param User $user
     */
    public function setFine(Lesson $lesson, User $user)
    {
        $user->update([
            'points' => $user->points - $lesson->fine,
        ]);
    }

    /**
     * Обновление статуса занятия студента
     *
     * @param LessonUser $lessonUser
     */
    public function updateStatusForLessonUser(Lesson $lesson, User $user, string $status)
    {
        LessonUser::where('lesson_id', $lesson->id)
            ->where('user_id', $user->id)
            ->update(['status' => $status]);
    }

    /**
     * Вернет true если все задания выполнены правильно
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
     * Вернет true если все задания выполнены (не обязательно правильно)
     *
     * @param Test $test
     * @param User $user
     * @return bool
     */
    public function allQuestionsCompleted(Test $test, User $user)
    {
        $countQuestionsInTest = $test->getCountQuestions();
        $countCompletedAnswers = $this->getCountCompletedAnswers($test, $user);

        return $countQuestionsInTest === $countCompletedAnswers;
    }

    public function setCompletedStatusForLessonUser(LessonUser $lessonUser)
    {
        $lessonUser->update(['status' => 'complete']);
    }

    /**
     * Подсчет числа правильных ответов в тесте $test для ученика $user
     *
     * @param Test $test
     * @param User $user
     * @return int
     */
    private function getCountRightAnswers(Test $test, User $user)
    {
        $questionIds = Question::whereTestId($test->id)->pluck('id');

        return QuestionUser::whereStatus('right')
            ->whereUserId($user->id)
            ->whereIn('question_id', $questionIds)->count();
    }

    /**
     * Подсчет числа ответов ученика $user в тесте $test
     *
     * @param Test $test
     * @param User $user
     * @return int
     */
    private function getCountCompletedAnswers(Test $test, User $user)
    {
        $questionIds = Question::whereTestId($test->id)->pluck('id');

        return QuestionUser::whereIn('question_id', $questionIds)
            ->whereIn('status', ['complete', 'right', 'wrong'])
            ->whereUserId($user->id)->count();
    }
}
