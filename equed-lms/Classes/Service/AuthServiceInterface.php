<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Enum\UserRole;

interface AuthServiceInterface
{
    public function getUserRole(int $frontendUserId): UserRole;

    public function isCertifier(int $frontendUserId): bool;

    public function isInstructor(int $frontendUserId): bool;

    public function isLearner(int $frontendUserId): bool;
}
