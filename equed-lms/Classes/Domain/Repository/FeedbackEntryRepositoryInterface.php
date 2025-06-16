<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use Equed\EquedLms\Domain\Model\FeedbackEntry;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface FeedbackEntryRepositoryInterface
{
    /**
     * @param CourseFeedback $courseFeedback
     * @return FeedbackEntry[]
     */
    public function findByCourseFeedback(CourseFeedback $courseFeedback): array;

    /**
     * @param CourseFeedback $courseFeedback
     * @return FeedbackEntry[]
     */
    public function findVisibleToInstructor(CourseFeedback $courseFeedback): array;

    /**
     * @return QueryInterface<FeedbackEntry>
     */
    public function createQuery(): QueryInterface;
}

