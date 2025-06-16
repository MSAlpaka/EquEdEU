<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * Data Transfer Object representing a frontend user's profile.
 */
final class UserProfileDto implements \JsonSerializable
{
    /**
     * @param int   $userId           FE user identifier
     * @param string $name             Display name
     * @param string $email            E-mail address
     * @param int[]  $roles            Numeric role identifiers
     * @param bool   $profileCompleted Whether the profile has been completed
     */
    public function __construct(
        private readonly int $userId,
        private readonly string $name,
        private readonly string $email,
        private readonly array $roles,
        private readonly bool $profileCompleted,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isProfileCompleted(): bool
    {
        return $this->profileCompleted;
    }

    public function jsonSerialize(): array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles,
            'profileCompleted' => $this->profileCompleted,
        ];
    }
}

