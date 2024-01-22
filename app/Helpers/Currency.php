<?php

namespace App\Helpers;

class Currency {
    public static function format($value, $decimals = 0) {
        return number_format($value, $decimals);
    }
}
