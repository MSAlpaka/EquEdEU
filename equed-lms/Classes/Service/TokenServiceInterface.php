<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;

interface TokenServiceInterface
{
    public function generateToken(FrontendUser $user): string;

    public function validateToken(string $token): ?FrontendUser;

    public function invalidateToken(FrontendUser $user): void;
}
