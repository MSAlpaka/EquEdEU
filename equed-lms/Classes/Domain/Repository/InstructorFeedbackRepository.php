<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\InstructorFeedback;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for InstructorFeedback entities.
 */
final class InstructorFeedbackRepository extends Repository
{
    /**
     * Finds all feedback entries for a specific instructor.
     *
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findByInstructor(FrontendUser $instructor): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $instructor)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds only participant feedback for a specific instructor.
     *
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findParticipantFeedback(FrontendUser $instructor): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('instructor', $instructor),
                $query->equals('fromParticipant', true),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return InstructorFeedback[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $courseInstance)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds unread feedback entries for a specific instructor.
     *
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findUnreadByInstructor(FrontendUser $instructor): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('instructor', $instructor),
                $query->equals('visibleToInstructor', true),
                $query->equals('readByInstructor', false),
            ])
        );

        return $query->execute()->toArray();
    }
}
// EOF
