<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\TrainingCenter;
use Equed\EquedLms\Domain\Model\TrainingCenterFeedback;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for TrainingCenterFeedback entities.
 */
final class TrainingCenterFeedbackRepository extends Repository
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
     * Finds all feedback for a specific training center.
     *
     * @param TrainingCenter $trainingCenter
     * @return TrainingCenterFeedback[]
     */
    public function findAllForCenter(TrainingCenter $trainingCenter): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('trainingCenter', $trainingCenter)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return TrainingCenterFeedback[]
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
     * Finds the latest feedback entry for a specific training center.
     *
     * @param TrainingCenter $trainingCenter
     * @return TrainingCenterFeedback|null
     */
    public function findLatestForCenter(TrainingCenter $trainingCenter): ?TrainingCenterFeedback
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('trainingCenter', $trainingCenter)
        );
        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }
}
// EOF
