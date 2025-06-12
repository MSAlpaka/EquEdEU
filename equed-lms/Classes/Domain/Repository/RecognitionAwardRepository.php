<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\RecognitionAward;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for RecognitionAward entities.
 */
final class RecognitionAwardRepository extends Repository
{
    /**
     * Default ordering: newest first.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Finds all active recognition awards (not marked deleted).
     *
     * @return RecognitionAward[]
     */
    public function findAllActive(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('deleted', 0)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all recognition awards for a given instructor.
     *
     * @param FrontendUser $user
     * @return RecognitionAward[]
     */
    public function findByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $user)
        );

        return $query->execute()->toArray();
    }
}
// EOF
