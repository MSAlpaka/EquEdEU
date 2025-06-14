<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\BadgeAwardServiceInterface;

use Equed\EquedLms\Domain\Repository\BadgeAwardRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LearningPathRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

final class BadgeAwardService implements BadgeAwardServiceInterface
{
    public function __construct(
        private readonly BadgeAwardRepositoryInterface       $awardRepo,
        private readonly UserCourseRecordRepositoryInterface $courseRecordRepo,
        private readonly LearningPathRepositoryInterface     $learningPathRepo,
        private readonly GptTranslationServiceInterface      $translationService
    ) {
    }

    /**
     * Award badges for all completed courses and learning paths without badges.
     *
     * @return int Total number of badges awarded
     */
    public function awardPendingBadges(): int
    {
        $awarded = 0;

        // 1) Course completion badges
        foreach ($this->courseRecordRepo->findCompletedWithoutBadge() as $record) {
            $userId       = $record->getFeUser()->getUid();
            $course       = $record->getCourse();
            $courseId     = $course->getUid();
            $courseTitle  = $course->getTitle();
            $label        = $this->translationService->translate(
                'badge.course_completion',
                ['course' => $courseTitle]
            );

            $this->awardRepo->addForCourse(
                $userId,
                $courseId,
                $label
            );

            $awarded++;
        }

        // 2) Learning path completion badges
        foreach ($this->learningPathRepo->findCompletedWithoutBadge() as $learningPath) {
            $userId      = $learningPath->getFeUser()->getUid();
            $lpId        = $learningPath->getUid();
            $lpTitle     = $learningPath->getTitle();
            $label       = $this->translationService->translate(
                'badge.learning_path_completion',
                ['path' => $lpTitle]
            );

            $this->awardRepo->addForLearningPath(
                $userId,
                $lpId,
                $label
            );

            $awarded++;
        }

        return $awarded;
    }
}

