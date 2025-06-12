<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface FrontendUserRepositoryInterface
{
    /**
     * @param string $token
     * @return FrontendUser|null
     */
    public function findByApiToken(string $token): ?FrontendUser;

    /**
     * @param FrontendUser $user
     * @return void
     */
    public function update(FrontendUser $user): void;

    /**
     * @return QueryInterface<FrontendUser>
     */
    public function createQuery(): QueryInterface;
}
