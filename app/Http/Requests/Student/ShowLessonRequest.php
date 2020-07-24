<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ShowLessonRequest extends FormRequest
{
    /**
     * Вернет false если студент не купил курс
     *
     * @return bool
     */
    public function authorize()
    {
        $lesson = $this->route('lesson');

        return !is_null($lesson->course->user) && $lesson->available();
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
