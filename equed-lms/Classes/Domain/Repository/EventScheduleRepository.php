<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Model\EventSchedule;

/**
 * Repository for {@link EventSchedule} entities.
 *
 * The repository currently implements no custom query methods. It acts as a
 * placeholder so that future event schedule related lookups can be added in a
 * central place. Until then it simply exposes the default Extbase persistence
 * behaviour.
 *
 * @extends Repository<EventSchedule>
 */
final class EventScheduleRepository extends Repository
{
}
