<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use Equed\EquedLms\Domain\Model\FrontendUser;

final class DefaultFrontendUserFactory implements FrontendUserFactoryInterface
{
    public function createWithUid(int $uid): FrontendUser
    {
        $user = new FrontendUser();
        $user->_setProperty('uid', $uid);

        return $user;
    }
}
