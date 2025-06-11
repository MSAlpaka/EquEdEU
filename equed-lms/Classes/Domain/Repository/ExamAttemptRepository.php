<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\ExamAttempt;
use Equed\EquedLms\Domain\Model\ExamTemplate;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for ExamAttempt entities.
 */
class ExamAttemptRepository extends Repository
{
    /**
     * Finds all attempts by a specific user for a given exam template.
     *
     * @param FrontendUser  $frontendUser
     * @param ExamTemplate  $template
     * @return ExamAttempt[]
     */
    public function findByUserAndTemplate(FrontendUser $frontendUser, ExamTemplate $template): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $frontendUser),
                $query->equals('examTemplate', $template),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all attempts that have not yet been scored.
     *
     * @return ExamAttempt[]
     */
    public function findUnscoredAttempts(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('scored', false)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all attempts by a specific frontend user.
     *
     * @param FrontendUser $frontendUser
     * @return ExamAttempt[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $frontendUser)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all attempts of a given type (e.g., theory, practical, casework).
     *
     * @param string $type
     * @return ExamAttempt[]
     */
    public function findByType(string $type): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('type', $type)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all attempts for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return ExamAttempt[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $courseInstance)
        );

        return $query->execute()->toArray();
    }
}
// EOF
