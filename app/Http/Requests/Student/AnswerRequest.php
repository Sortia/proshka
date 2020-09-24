<?php

namespace App\Http\Requests\Student;

use App\Question;
use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $question = Question::findOrFail(request()->question_id);

        // если урок не куплен
        if (is_null($question->test->lesson->user)) {
            return false;
        }

        // если ответа еще не было
        if (is_null($question->user)) {
            return true;
        }

        // если ответ был, но учитель отправил на доработку
        if ($question->user->status === 'rework') {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
