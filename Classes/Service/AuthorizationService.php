<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

/**
 * Basic authorization service using simple role arrays.
 *
 * Roles can either be passed in the constructor or provided through the
 * global `$_SESSION['roles']` array. The checks are case insensitive.
 */
class AuthorizationService
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

    private function hasRole(string $role): bool
    {
        return in_array(strtolower($role), $this->roles, true);
    }

    public function isCertifier(): bool
    {
        return $this->hasRole('certifier');
    }

    public function isServiceCenter(): bool
    {
        return $this->hasRole('servicecenter');
    }

    public function isInstructor(): bool
    {
        return $this->hasRole('instructor');
    }
}
