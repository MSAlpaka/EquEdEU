<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Model\EventBooking;

/**
 * Repository for {@link EventBooking} entities.
 *
 * This class is intentionally empty and merely extends the base
 * {@link Repository} in order to provide a dedicated extension point for
 * future EventBooking specific queries. Consumers can add custom methods as
 * requirements evolve, while the default Extbase persistence behaviour is
 * available out of the box.
 *
 * @extends Repository<EventBooking>
 */
final class EventBookingRepository extends Repository
{
}
