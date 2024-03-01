<?php
namespace App\Enums;

enum ResourceTypeEnums: String {
    case image = 'image';
    case doc   = 'document';
    case video = 'video';

    public static function byValue($value)
    {
        return collect(ResourceTypeEnums::cases())->firstWhere('value', $value);
    }
}
