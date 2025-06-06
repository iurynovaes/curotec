<?php

namespace App\Enums;

enum JobType: string
{
    case FullTime = 'full-time';
    case PartTime = 'part-time';
    case Freelance = 'freelance';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
