<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;

/**
 * Basic authorization service using simple role arrays.
 *
 * Roles can either be passed in the constructor or provided through the
 * global `$_SESSION['roles']` array. The checks are case insensitive.
 */
class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var string[]
     */
    private array $roles;

    /**
     * @param string[] $roles Optional roles for the current user
     */
    public function __construct(array $roles = [])
    {
        if ($roles === []) {
            $roles = isset($_SESSION['roles']) && is_array($_SESSION['roles'])
                ? $_SESSION['roles']
                : [];
        }

        $this->roles = array_map('strtolower', $roles);
    }

    /**
     * Check if the current user has the given role.
     *
     * @param string $role Role identifier
     * @return bool True if the user has the role
     */
    private function hasRole(string $role): bool
    {
        return in_array(strtolower($role), $this->roles, true);
    }

    /**
     * Determine whether the current user is a certifier.
     *
     * @return bool True when the user has the certifier role
     */
    public function isCertifier(): bool
    {
        return $this->hasRole('certifier');
    }

    /**
     * Determine whether the current user is a service center.
     *
     * @return bool True when the user has the service center role
     */
    public function isServiceCenter(): bool
    {
        return $this->hasRole('servicecenter');
    }

    /**
     * Determine whether the current user is an instructor.
     *
     * @return bool True when the user has the instructor role
     */
    public function isInstructor(): bool
    {
        return $this->hasRole('instructor');
    }
}
