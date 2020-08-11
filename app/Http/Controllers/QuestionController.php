<?php

namespace App\Http\Controllers;

use App\Constants\QuestionUserStatus;
use App\Http\Requests\Student\AnswerRequest;
use App\Http\Services\FileService;
use App\QuestionUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Сохранение ответа на тест
     *
     * @param Request $request
     * @return Response
     */
    public function store(AnswerRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $questionUser = QuestionUser::create([
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
}
