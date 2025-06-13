<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use Equed\EquedLms\Domain\Model\FrontendUser;

interface FrontendUserFactoryInterface
{
    public function createWithUid(int $uid): FrontendUser;
}
