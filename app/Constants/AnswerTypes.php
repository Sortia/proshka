<?php

namespace App\Constants;

class AnswerTypes
{
    const SELECT = 'select';
    const TEXT = 'text';
    const NONE = 'none';
    const SELECT_MANY = 'select_many';

    public static function getList()
    {
        return [
            self::SELECT => 'Choice from several',
            self::TEXT => 'Text field',
            self::NONE => 'There is no choice',
            self::SELECT_MANY => 'Select many',
        ];
    }
}
