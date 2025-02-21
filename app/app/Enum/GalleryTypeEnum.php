<?php

declare(strict_types=1);

namespace App\Enum;

enum GalleryTypeEnum: string
{
    case TYPE_MAIN = 'TYPE_MAIN';
    case TYPE_OCCURRENCE = 'TYPE_OCCURRENCE';
}