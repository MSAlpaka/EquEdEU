<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\RecognitionAward;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\RecognitionAwardRepositoryInterface;

/**
 * Repository for RecognitionAward entities.

 *
 * @extends Repository<RecognitionAward>
 */
final class RecognitionAwardRepository extends Repository implements RecognitionAwardRepositoryInterface
{
    /**
     * Default ordering: newest first.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Finds all active recognition awards (not marked deleted).
     *
     * @return RecognitionAward[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
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

    /**
     * Finds all recognition awards for a frontend user by ID.
     *
     * @param int $feUserId
     * @return RecognitionAward[]
     */
    public function findByFeUser(int $feUserId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $feUserId)
        );

        return $query->execute()->toArray();
    }
}
