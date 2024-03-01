<?php

namespace App\Enums;

enum AccountEnums: Int {
    case student = 0;
    case admin   = 1;
    case both    = 2;

    public static function byValue($value)
    {
        return collect(AccountEnums::cases())->firstWhere('value', $value);
    }
}
