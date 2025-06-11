<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface FrontendUserRepositoryInterface
{
    public function findByApiToken(string $token): ?FrontendUser;

    /**
     * @param FrontendUser $user
     */
    public function update($object);

    public function createQuery();
}
