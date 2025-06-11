<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Service for generating, validating, and invalidating API tokens for frontend users.
 */
final class TokenService
{
    public function __construct(
        private readonly FrontendUserRepositoryInterface $frontendUserRepository,
        private readonly PersistenceManagerInterface $persistenceManager
    ) {
    }

    /**
     * Generates a new API token for the given user and persists it.
     *
     * @param FrontendUser $user
     * @return string The newly generated API token
     */
    public function generateToken(FrontendUser $user): string
    {
        $token = bin2hex(random_bytes(16));
        $user->setApiToken($token);
        $this->frontendUserRepository->update($user);
        $this->persistenceManager->persistAll();

        return $token;
    }

    /**
     * Validates the given API token and returns the corresponding user.
     *
     * @param string $token
     * @return FrontendUser|null The user if token is valid; null otherwise
     */
    public function validateToken(string $token): ?FrontendUser
    {
        return $this->frontendUserRepository->findByApiToken($token);
    }

    /**
     * Invalidates the API token for the given user.
     *
     * @param FrontendUser $user
     */
    public function invalidateToken(FrontendUser $user): void
    {
        $user->setApiToken(null);
        $this->frontendUserRepository->update($user);
        $this->persistenceManager->persistAll();
    }
}
