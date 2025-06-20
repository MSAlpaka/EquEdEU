<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseCompletionServiceInterface;
use Equed\EquedLms\Dto\CourseViewModel;

/**
 * Service responsible for preparing the view model for course progress pages.
 */
final class CourseProgressService implements CourseProgressServiceInterface
{
    public function __construct(
        private readonly CourseRepositoryInterface $courseRepository,
        private readonly LessonProgressRepositoryInterface $lessonProgressRepository,
        private readonly CourseCompletionServiceInterface $courseCompletionService,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    public function getCourseViewModel(int $courseUid, int $userId): CourseViewModel
    {
        if ($courseUid <= 0) {
            return new CourseViewModel(error: $this->translationService->translate('error.noCourseSelected'));
        }

        $course = $this->courseRepository->findByUid($courseUid);
        if ($course === null) {
            return new CourseViewModel(error: $this->translationService->translate('error.courseNotFound'));
        }

        $lessons = $course->getLessons();
        $totalLessons = $lessons->count();
        $progressPercent = 0;

        if ($userId > 0 && $totalLessons > 0) {
            $completed = $this->lessonProgressRepository
                ->countCompletedByUserAndLessons($userId, $lessons->toArray());
            $progressPercent = (int) round(($completed / $totalLessons) * 100);

            if ($progressPercent === 100) {
                $this->courseCompletionService->markCompletedIfNotYet($userId, $courseUid);
            }
        }

        return new CourseViewModel(
            course: $course,
            progress: $progressPercent,
        );
    }
}
