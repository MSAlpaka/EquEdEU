<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for retrieving and formatting user progress data.
 */
final class ProgressService implements ProgressServiceInterface
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly string $extensionKey = 'equed_lms'
    ) {
    }

    /**
     * Returns overall and per-course progress for the given user.
     *
     * @param int|FrontendUser $user FE user ID or object
     * @return array{
     *   overallPercent: int,
     *   courses: array<int, array{
     *     courseId: int|null,
     *     courseTitle: string|null,
     *     progress: int,
     *     status: string
     *   }>
     * }
     */
    public function getProgressDataForUser(int|FrontendUser $user): array
    {
        $userId = $user instanceof FrontendUser ? (int)$user->getUid() : $user;
        $records = $this->userCourseRecordRepository->findByUserId($userId);
        $total = count($records);
        $sum = 0;
        $courses = [];

        foreach ($records as $record) {
            $progress = (int) round($record->getProgressPercent());
            $sum += $progress;

            /** @var CourseInstance $instance */
            $instance = $record->getCourseInstance();
            /** @var CourseProgram|null $program */
            $program = $instance->getCourseProgram();

            $courses[] = [
                'courseId'    => $program?->getUid(),
                'courseTitle' => $instance->getTitle(),
                'progress'    => $progress,
                'status'      => $this->translateStatus($record->getStatus()->value),
            ];
        }

        $overall = $total > 0 ? (int) round($sum / $total) : 0;

        return [
            'overallPercent' => $overall,
            'courses'        => $courses,
        ];
    }

    /**
     * Translate a status code into a localized label.
     *
     * @param string $statusCode
     * @return string
     */
    private function translateStatus(string $statusCode): string
    {
        $key = match ($statusCode) {
            'completed'   => 'status.completed',
            'inProgress'  => 'status.inProgress',
            default       => 'status.notStarted',
        };

        return $this->translate($key, ['status' => $statusCode]);
    }

    /**
     * Translate a localization key with GPT-based service and fallback.
     *
     * @param string              $key        Localization key
     * @param array<string,mixed> $arguments  Placeholder arguments
     * @return string
     */
    private function translate(string $key, array $arguments = []): string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, $this->extensionKey);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey, $arguments) ?? $key;
    }

    public function cleanupAbandonedCourseProgress(int $days): void
    {
        // no-op placeholder to satisfy interface
    }
}
