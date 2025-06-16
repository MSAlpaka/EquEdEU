<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\EventBooking;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface EventBookingRepositoryInterface
{
    /**
     * @return QueryInterface<EventBooking>
     */
    public function createQuery(): QueryInterface;
}

