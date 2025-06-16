<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

interface FeedbackRepositoryInterface
{
    /**
     * @param FrontendUser $user
     * @return CourseFeedback[]
     */
    public function findByFeUser(FrontendUser $user): array;

    /**
     * @return CourseFeedback[]
     */
    public function findUnseenFeedback(): array;

    /**
     * @return QueryResultInterface<CourseFeedback>
     */
    public function findUnanalyzed(): QueryResultInterface;

    /**
     * @param FrontendUser   $user
     * @param CourseInstance $courseInstance
     * @return CourseFeedback|null
     */
    public function findByUserAndCourse(FrontendUser $user, CourseInstance $courseInstance): ?CourseFeedback;

    /**
     * @return QueryInterface<CourseFeedback>
     */
    public function createQuery(): QueryInterface;
}

