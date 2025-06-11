<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\CourseRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseCompletionServiceInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for displaying course details and tracking user progress.
 *
 * Utilizes GPT-based translation service for all human-readable output,
 * supporting hybrid live translation with fallback (EN → DE → FR → ES → SW → EASY).
 */
final class CourseController extends ActionController
{
    public function __construct(
        private readonly CourseRepositoryInterface $courseRepository,
        private readonly LessonProgressRepositoryInterface $lessonProgressRepository,
        private readonly CourseCompletionServiceInterface $courseCompletionService,
        private readonly Context $context,
        private readonly GptTranslationServiceInterface $translationService
    ) {
        parent::__construct();
    }

    /**
     * Displays the selected course and calculates the user's progress.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function showAction(): ResponseInterface
    {
        $courseUid = (int)($this->settings['course'] ?? 0);
        if ($courseUid <= 0) {
            $this->addFlashMessage(
                $this->translationService->translate('error.noCourseSelected'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            return $this->redirect('list');
        }

        $course = $this->courseRepository->findByUid($courseUid);
        if ($course === null) {
            $this->addFlashMessage(
                $this->translationService->translate('error.courseNotFound'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            return $this->redirect('list');
        }

        $userId = (int)$this->context->getAspect('frontend.user')->get('id');
        $lessons = $course->getLessons();
        $totalLessons = $lessons->count();
        $progressPercent = 0;

        if ($userId > 0 && $totalLessons > 0) {
            $completed = $this->lessonProgressRepository
                ->countCompletedByUserAndLessons($userId, $lessons->toArray());
            $progressPercent = (int)round(($completed / $totalLessons) * 100);

            if ($progressPercent === 100) {
                $this->courseCompletionService->markCompletedIfNotYet($userId, $courseUid);
            }
        }

        $this->view->assignMultiple([
            'course' => $course,
            'lessons' => $lessons,
            'progressPercent' => $progressPercent,
            'userId' => $userId,
        ]);

        return $this->htmlResponse();
    }
}
// End of file
