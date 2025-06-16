<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\EventSchedule;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface EventScheduleRepositoryInterface
{
    /**
     * @return QueryInterface<EventSchedule>
     */
    public function createQuery(): QueryInterface;
}

