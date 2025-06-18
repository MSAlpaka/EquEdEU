<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Service;

interface AuthorizationServiceInterface
{
    public function isCertifier(): bool;

    public function isServiceCenter(): bool;

    public function isInstructor(): bool;
}
