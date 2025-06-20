<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeQuestion;
use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\PracticeQuestionRepositoryInterface;

/**
 * Repository for PracticeQuestion entities.

 *
 * @extends Repository<PracticeQuestion>
 */
final class PracticeQuestionRepository extends Repository implements PracticeQuestionRepositoryInterface
{
    /**
     * Finds all active practice questions (not marked deleted).
     *
     * @return PracticeQuestion[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Find a practice question by UID.
     *
     * @param int $uid
     * @return PracticeQuestion|null
     */
    public function findByUid(int $uid): ?PracticeQuestion
    {
        return $this->findByIdentifier($uid);
    }

    /**
     * Finds all questions for a specific practice test.
     *
     * @param PracticeTest $practiceTest
     * @return PracticeQuestion[]
     */
    public function findByPracticeTest(PracticeTest $practiceTest): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('practiceTest', $practiceTest)
        );

        return $query->execute()->toArray();
    }
}
