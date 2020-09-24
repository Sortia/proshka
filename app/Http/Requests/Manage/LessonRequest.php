<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role_id === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required|numeric',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'complexity' => 'required|numeric',
            'order_number' => 'required|numeric',
            'cost' => 'required|numeric',
            'bonus' => 'required|numeric',
            'time' => 'required|numeric',
            'available_at' => 'required|numeric',
        ];
    }
}
