<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\SystemSettings;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\SystemSettingsRepositoryInterface;

/**
 * Repository for {@link SystemSettings} entities.
 *
 * The repository stores system wide configuration values. It currently does not
 * define any custom query methods and simply inherits the default Extbase
 * {@link Repository} behaviour. New lookup logic can be introduced here when
 * required.
 *
 * @extends Repository<SystemSettings>
 */
final class SystemSettingsRepository extends Repository implements SystemSettingsRepositoryInterface
{
}
