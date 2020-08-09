<?php

namespace App\Constants;

class AnswerTypes
{
    const SELECT = 'select';
    const TEXT = 'text';
    const NONE = 'none';

    public static function getList()
    {
        return [
            self::SELECT => 'Choice from several',
            self::TEXT => 'Text field',
            self::NONE => 'Without field',
        ];
    }
}
