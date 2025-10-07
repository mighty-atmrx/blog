<?php

namespace App\Domain\Post\Enum;

enum StateEnum: string
{
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case REMOVED = 'removed';
}
