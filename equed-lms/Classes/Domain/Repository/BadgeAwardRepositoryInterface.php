<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\BadgeAward;

interface BadgeAwardRepositoryInterface
{
    /**
     * @param int $feUserId
     * @return BadgeAward[]
     */
    public function findByFeUser(int $feUserId): array;

    public function addForCourse(int $userId, int $courseId, string $label): void;

    public function addForLearningPath(int $userId, int $pathId, string $label): void;
}
