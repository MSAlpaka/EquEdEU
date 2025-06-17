<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Service\LogService;

/**
 * Handles progress synchronization between app and LMS.
 */
final class UserProgressSyncService
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly LogService $logService
    ) {
    }

    /**
     * Returns current progress records for the user.
     *
     * @param int $userId
     * @return array<int, array{recordId: int, status: string, updatedAt: string|null}>
     */
    public function exportUserProgress(int $userId): array
    {
        $records = $this->recordRepository->findByUserId($userId);

        return array_map(
            fn (UserCourseRecord $record): array => [
                'recordId'  => $record->getUid(),
                'status'    => $record->getStatus(),
                'updatedAt' => $record->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ],
            $records
        );
    }

    /**
     * Syncs updated progress from external system.
     *
     * @param array<array{recordId: int, status: string, updatedAt: string}> $updates
     * @return int Number of records updated
     */
    public function syncUserProgress(array $updates): int
    {
        $count = 0;

        foreach ($updates as $data) {
            $record = $this->recordRepository->findByUid((int)$data['recordId']);
            if ($record === null) {
                continue;
            }

            $remoteTime = \DateTimeImmutable::createFromFormat(DATE_ATOM, $data['updatedAt']);
            if ($remoteTime === false) {
                $this->logService->logWarning(
                    'Invalid timestamp for progress sync',
                    ['value' => $data['updatedAt'], 'recordId' => $data['recordId']]
                );
                continue;
            }
            if ($record->getUpdatedAt() !== null && $remoteTime <= $record->getUpdatedAt()) {
                continue;
            }

            $record->setStatus($data['status']);
            $record->setUpdatedAt($remoteTime);

            $this->recordRepository->update($record);
            $count++;
        }

        $this->persistenceManager->persistAll();
        return $count;
    }
}
