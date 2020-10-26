<?php

namespace App\Http\Services;

use App\Question;
use App\Test;
use Exception;

class TestService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param int $lessonId
     * @return Test
     */
    public function saveTest(int $lessonId): Test
    {
        return Test::on()->updateOrCreate(['lesson_id' => $lessonId]);
    }

    /**
     * Сохраняет или апдейтит вопрос
     *
     * @param Test $test
     * @param array $questionData
     * @return Question
     */
    public function saveQuestion(Test $test, array $questionData): Question
    {
        $id = $questionData['index'] > 0 ? $questionData['index'] : null;

        return $test->questions()->updateOrCreate(['id' => $id], $questionData);
    }

    /**
     * Сохраняет файлы прикрепленные к вопросу (если они есть)
     *
     * @param Question $question
     * @param array|null $files
     * @return void
     */
    public function saveQuestionFiles(Question $question, ?array $files): void
    {
        if (!is_null($files)) {
            foreach ($files as $file) {
                $this->fileService->save($question, $file, 'questions');
            }
        }
    }

    /**
     * Сохраняет варианты ответа на вопрос (если они есть)
     *
     * @param Question $question
     * @param array|null $answers
     * @return void
     */
    public function saveQuestionAnswers(Question $question, ?array $answers): void
    {
        $question->refresh();

        $question->answers->each(function ($item) use ($answers) {
            if (!in_array($item->id, array_column($answers, 'id'))) {
                $item->delete();
            }
        });

        if (!is_null($answers)) {
            for ($i = 0; $i < count($answers); $i++) {
                $answers[$i]['order_number'] = $i;

                $question->answers()->updateOrCreate(['id' => $answers[$i]['id']], $answers[$i]);
            }
        }
    }

    /**
     * Сравнивает файлы которые были сохранены ранее и файлы, id которых пришли с фронта
     * если каких-то id не хватает (были удалены на форме) удаляет эти файлы из базы и хранилища
     *
     * @param Test $test
     * @param array $inlineFiles
     * @return void
     */
    public function deleteFilesIfNeed(Test $test, array $inlineFiles): void
    {
        $files = $test->questions->pluck('files')->collapse();

        foreach ($files ?? [] as $file) {
            if (!in_array($file->id, array_column($inlineFiles, 'id'))) {
                $this->fileService->delete($file);
            }
        }
    }

    /**
     * Сравнивает вопросы в базе с вопросами пришедшими с фронта.
     * Если какие-то с фронта не пришли - удаляет их и их базы (вместе с файлами)
     *
     * @param Test $test
     * @param array $questionsData
     * @throws Exception
     * @return void
     */
    public function deleteQuestionsIfNeed(Test $test, array $questionsData): void
    {
        foreach ($test->questions as $question) {
            if (!in_array($question->id, array_column($questionsData, 'index'))) {
                $this->deleteQuestion($question);
            }
        }
    }

    /**
     * Удаление вопроса (вместе с файлами, если они есть)
     *
     * @param Question $question
     * @throws Exception
     * @return void
     */
    private function deleteQuestion(Question $question): void
    {
        foreach ($question->files as $file) {
            $this->fileService->delete($file);
        }

        $question->delete();
    }

}
