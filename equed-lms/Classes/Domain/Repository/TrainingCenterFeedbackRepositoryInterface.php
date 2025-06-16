<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\TrainingCenter;
use Equed\EquedLms\Domain\Model\TrainingCenterFeedback;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface TrainingCenterFeedbackRepositoryInterface
{
    /**
     * @param TrainingCenter $trainingCenter
     * @return TrainingCenterFeedback[]
     */
    public function findAllForCenter(TrainingCenter $trainingCenter): array;

    /**
     * @param CourseInstance $courseInstance
     * @return TrainingCenterFeedback[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array;

    /**
     * @param TrainingCenter $trainingCenter
     * @return TrainingCenterFeedback|null
     */
    public function findLatestForCenter(TrainingCenter $trainingCenter): ?TrainingCenterFeedback;

    /**
     * @return QueryInterface<TrainingCenterFeedback>
     */
    public function createQuery(): QueryInterface;
}

