<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Service;

interface LmsIntegrationServiceInterface
{
    public function syncInstructorLevel(int $userId, string $level): void;
}
