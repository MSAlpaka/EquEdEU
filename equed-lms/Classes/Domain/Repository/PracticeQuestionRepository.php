<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeQuestion;
use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for PracticeQuestion entities.
 */
class PracticeQuestionRepository extends Repository
{
    /**
     * Finds all active practice questions (not marked deleted).
     *
     * @return PracticeQuestion[]
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
// EOF
