<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LearningPath;

interface LearningPathRepositoryInterface
{
    /**
     * @return LearningPath[]
     */
    public function findCompletedWithoutBadge(): array;
}
