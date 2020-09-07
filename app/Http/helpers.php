<?php

function get_case_for_points($number) {
    $root = 'прош';
    $cases = [
        'ка',
        'ки',
        'ек',
    ];

    $lastNumber = \Illuminate\Support\Str::substr($number, -1);

    switch ($lastNumber) {
        case '1':
            return $root . $cases[0];
        case '2':
        case '3':
        case '4':
            return $root . $cases[1];
        default:
            return $root . $cases[2];
    }
}
