<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\RecognitionAward;

interface RecognitionAwardRepositoryInterface
{
    /**
     * Find all recognition awards for a frontend user.
     *
     * @param int $feUserId FE user identifier
     * @return RecognitionAward[]
     */
    public function findByFeUser(int $feUserId): array;
}

