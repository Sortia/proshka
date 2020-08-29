<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class CheckRepresentative implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::whereEmail($value)->whereRoleId(4)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Представитель с таким E-Mail не зарегистирован';
    }
}
