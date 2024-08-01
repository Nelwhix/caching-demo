<?php

declare(strict_types=1);

namespace Database\Enums;

enum FileType: int
{
    case Picture = 1;
    case GIF = 2;
    case Video = 3;
}
