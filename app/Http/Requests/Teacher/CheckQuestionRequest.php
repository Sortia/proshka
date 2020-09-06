<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CheckQuestionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'additional_points' => 'numeric|min:0|max:10'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
