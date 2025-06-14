<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface BadgeAwardServiceInterface
{
    /**
     * Award badges for completed courses and learning paths.
     *
     * @return int Number of badges awarded
     */
    public function awardPendingBadges(): int;
}

