<?php

namespace App\Enums;

enum ExperienceLevel: string
{
    case Junior = 'junior';
    case Mid = 'mid';
    case Senior = 'senior';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
