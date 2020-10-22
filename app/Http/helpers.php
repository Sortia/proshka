<?php

function get_points_name($number = 0, $type = null) {
    $names = config('app.point_name');

    if (!is_null($type)) {
        return $names[$type];
    }

    $lastNumber = \Illuminate\Support\Str::substr($number, -1);

    switch ($lastNumber) {
        case '1':
            return $names['first'];
        case '2':
        case '3':
        case '4':
            return $names['second'];
        default:
            return $names['third'];
    }
}
