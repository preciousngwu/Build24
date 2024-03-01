<?php
namespace App\Enums;

enum LessonTypeEnums: String {
    case standard = 'standard';
    case table    = 'table';
    case note     = 'note';
    case pdf      = 'pdf';


    public static function byValue($value)
    {
        return collect(LessonTypeEnums::cases())->firstWhere('value', $value);
    }
}
