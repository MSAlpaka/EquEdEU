<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for FrontendUser entities.
 *
 * @extends Repository<FrontendUser>
 */

final class FrontendUserRepository extends Repository implements FrontendUserRepositoryInterface
{
    /**
     * Find a user by API token.
     *
     * @param string $token API token
     * @return FrontendUser|null The user if found, null otherwise
     */
    public function findByApiToken(string $token): ?FrontendUser
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('apiToken', $token)
        );
        $query->setLimit(1);

        $user = $query->execute()->getFirst();

        return $user instanceof FrontendUser ? $user : null;
    }

    /**
     * @param FrontendUser $user
     * @return void
     */
    public function update(FrontendUser $user): void
    {
        parent::update($user);
    }
}
