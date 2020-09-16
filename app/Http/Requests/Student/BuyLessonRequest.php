<?php

namespace App\Http\Requests\Student;

use App\LessonUser;
use Illuminate\Foundation\Http\FormRequest;

class BuyLessonRequest extends FormRequest
{
    /**
     * Нельзя взять одновременно более одного задания на выполнение
     *
     * @return bool
     */
    public function authorize()
    {
        return !LessonUser
            ::where('user_id', auth()->user()->id)
            ->whereIn('status', ['active', 'complete'])
            ->exists();
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
