<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use Equed\EquedLms\Domain\Factory\LessonProgressFactoryInterface;
use Equed\EquedLms\Domain\Model\LessonProgress;

final class DefaultLessonProgressFactory implements LessonProgressFactoryInterface
{
    public function create(): LessonProgress
    {
        return new LessonProgress();
    }
}
