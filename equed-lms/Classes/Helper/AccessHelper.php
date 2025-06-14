<?php

declare(strict_types=1);

namespace Equed\EquedLms\Helper;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\UserRole;

/**
 * AccessHelper service for checking user roles and permissions.
 */
final class AccessHelper
{
    public function __construct(
        protected readonly BackendUserAuthentication $backendUser,
        protected readonly Context $context
    ) {
    }

    /**
     * Check if the given frontend user has the instructor role.
     */
    /**
     * @param array<string, mixed>|FrontendUser $user
     */
    public function isInstructor(array|FrontendUser $user): bool
    {
        return $this->hasRole($user, UserRole::Instructor);
    }

    /**
     * Check if the given frontend user has the certifier role.
     */
    /**
     * @param array<string, mixed>|FrontendUser $user
     */
    public function isCertifier(array|FrontendUser $user): bool
    {
        return $this->hasRole($user, UserRole::Certifier);
    }

    /**
     * Check if the given frontend user has the service center role.
     */
    /**
     * @param array<string, mixed>|FrontendUser $user
     */
    public function isServiceCenter(array|FrontendUser $user): bool
    {
        return $this->hasRole($user, UserRole::ServiceCenter);
    }

    /**
     * Check if current backend user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->backendUser->isAdmin();
    }

    /**
     * Check if the given frontend user has a specific role.
     *
     * @param array<string, mixed>|FrontendUser $user
     */
    public function hasRole(array|FrontendUser $user, UserRole $targetRole): bool
    {
        $rolesField = $user instanceof FrontendUser
            ? $user->getUsergroup()
            : (is_array($user['usergroup'] ?? null) ? $user['usergroup'] : []);
        $roleList = [];

        foreach ($rolesField ?: [] as $group) {
            if (is_object($group) && method_exists($group, 'getTitle')) {
                $roleList[] = $group->getTitle();
            } elseif (is_array($group) && isset($group['title'])) {
                $roleList[] = $group['title'];
            }
        }

        return in_array($targetRole->value, $roleList, true);
    }
}
// EOF
