<?php

use Illuminate\Support\Facades\Blade;

function print_task(?string $task) {
    $php = Blade::compileString($task);
    $obLevel = ob_get_level();
    ob_start();

    try {
        eval('?' . '>' . $php);
    } catch (Exception $e) {
        while (ob_get_level() > $obLevel) ob_end_clean();
        throw $e;
    }
    return ob_get_clean();
}
