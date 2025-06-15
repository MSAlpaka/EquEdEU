<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Enum\ProgressStatus;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Service\LogService;

final class LessonProgressSyncService
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository,
        private readonly LessonRepositoryInterface $lessonRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly ClockInterface $clock,
        private readonly LogService $logService
    ) {
    }

    public function exportForApp(int $userId): array
    {
        $entries = $this->progressRepository->findByUserId($userId);
        $result = [];

        foreach ($entries as $entry) {
            $result[] = [
                'lessonId'   => $entry->getLesson()->getUid(),
                'progress'   => $entry->getProgress(),
                'status'     => $entry->getStatus()->value,
                'completed'  => $entry->isCompleted(),
                'updatedAt'  => $entry->getUpdatedAt()?->format(DATE_ATOM),
            ];
        }

        return $result;
    }

    public function syncFromApp(array $progressData, int $userId): void
    {
        foreach ($progressData as $item) {
            $lesson = $this->lessonRepository->findByUid((int) $item['lessonId']);
            if ($lesson === null) {
                continue;
            }

            $entry = $this->progressRepository->findByUserAndLesson($userId, $lesson->getUid()) ?? new LessonProgress();
            try {
                $remoteUpdated = new \DateTimeImmutable($item['updatedAt'] ?? 'now');
            } catch (\Exception $e) {
                $this->logService->logWarning(
                    'Invalid timestamp for progress sync',
                    ['value' => $item['updatedAt'] ?? null, 'lessonId' => $item['lessonId'] ?? null]
                );
                continue;
            }
            $localUpdated = $entry->getUpdatedAt();

            if (!$localUpdated || $remoteUpdated > $localUpdated) {
                $entry->setFeUser($userId);
                $entry->setLesson($lesson);
                $entry->setProgress((int) $item['progress']);
                $statusValue = $item['status'] ?? 'notStarted';
                $entry->setStatus(ProgressStatus::from($statusValue));
                $entry->setCompleted((bool) $item['completed']);
                $entry->setUpdatedAt($this->clock->now());
            }

            $this->progressRepository->updateOrAdd($entry);
        }

        $this->persistenceManager->persistAll();
    }
}
