<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\SystemSettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface SystemSettingsRepositoryInterface
{
    /**
     * @return QueryInterface<SystemSettings>
     */
    public function createQuery(): QueryInterface;
}

