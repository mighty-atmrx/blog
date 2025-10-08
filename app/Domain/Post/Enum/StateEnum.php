<?php

namespace App\Domain\Post\Enum;

enum StateEnum: string
{
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
    case REMOVED = 'removed';

    public static function values(): array
    {
        return [
            self::PUBLISHED->value,
            self::UNPUBLISHED->value,
            self::REMOVED->value,
        ];
    }
}
