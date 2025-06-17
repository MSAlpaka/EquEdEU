<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Factory;

use Equed\EquedLms\Domain\Model\LessonProgress;

interface LessonProgressFactoryInterface
{
    public function create(): LessonProgress;
}
