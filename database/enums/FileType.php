<?php

declare(strict_types=1);

namespace Database\Enums;

enum FileType: int
{
    case Picture = 1;
    case GIF = 2;
    case Video = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
