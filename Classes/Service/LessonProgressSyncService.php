<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Model\Lesson;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

final class LessonProgressSyncService
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository,
        private readonly LessonRepositoryInterface $lessonRepository,
        private readonly PersistenceManagerInterface $persistenceManager
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
                'status'     => $entry->getStatus(),
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
            $remoteUpdated = new \DateTimeImmutable($item['updatedAt'] ?? 'now');
            $localUpdated = $entry->getUpdatedAt();

            if (!$localUpdated || $remoteUpdated > $localUpdated) {
                $entry->setFeUser($userId);
                $entry->setLesson($lesson);
                $entry->setProgress((int) $item['progress']);
                $entry->setStatus($item['status'] ?? 'incomplete');
                $entry->setCompleted((bool) $item['completed']);
                $entry->setUpdatedAt(new \DateTimeImmutable());
            }

            $this->progressRepository->updateOrAdd($entry);
        }

        $this->persistenceManager->persistAll();
    }
}
