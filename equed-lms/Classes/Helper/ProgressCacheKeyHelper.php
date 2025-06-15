<?php

declare(strict_types=1);

namespace Equed\EquedLms\Helper;

/**
 * Generates cache keys for user progress data.
 */
final class ProgressCacheKeyHelper
{
    public const TEMPLATE = 'progress_%d_%d';

    public static function courseInstance(int $userId, int $courseInstanceId): string
    {
        return sprintf(self::TEMPLATE, $userId, $courseInstanceId);
    }
}
