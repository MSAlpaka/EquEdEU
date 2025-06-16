<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\InstructorFeedback;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface InstructorFeedbackRepositoryInterface
{
    /**
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findByInstructor(FrontendUser $instructor): array;

    /**
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findParticipantFeedback(FrontendUser $instructor): array;

    /**
     * @param CourseInstance $courseInstance
     * @return InstructorFeedback[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array;

    /**
     * @param FrontendUser $instructor
     * @return InstructorFeedback[]
     */
    public function findUnreadByInstructor(FrontendUser $instructor): array;

    /**
     * @return QueryInterface<InstructorFeedback>
     */
    public function createQuery(): QueryInterface;
}

