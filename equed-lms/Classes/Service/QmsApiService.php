<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\QmsSubmitRequest;
use Equed\EquedLms\Dto\QmsRespondRequest;
use Equed\EquedLms\Dto\QmsCloseRequest;
use Equed\EquedLms\Dto\QmsCaseData;

/**
 * Simple DB-driven operations for QMS API endpoints.
 */
final class QmsApiService
{
    public function __construct(
        private readonly QmsCaseRecordRepositoryInterface $repository,
        private readonly ClockInterface $clock
    ) {
    }

    /**
     * Fetch QMS cases submitted by the given user.
     *
     * @return array<int, QmsCaseData>
     */
    public function getCasesForUser(int $userId): array
    {
        $rows = $this->repository->findByUserId($userId);

        return array_map(
            fn (array $row): QmsCaseData => new QmsCaseData(
                (int)$row['uid'],
                (int)$row['usercourserecord'],
                (string)$row['type'],
                (string)$row['message'],
                (string)$row['status'],
                (int)$row['submitted_at'],
                isset($row['responded_at']) ? (int)$row['responded_at'] : null,
                isset($row['closed_at']) ? (int)$row['closed_at'] : null,
            ),
            $rows
        );
    }

    public function submitCase(QmsSubmitRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->repository->addCase(
            $dto->getUserId(),
            $dto->getRecordId(),
            $dto->getType(),
            $dto->getMessage(),
            $now
        );
    }

    public function respondToCase(QmsRespondRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->repository->respondToCase(
            $dto->getCaseId(),
            $dto->getUserId(),
            $dto->getRole(),
            $dto->getResponse(),
            $now
        );
    }

    public function closeCase(QmsCloseRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->repository->closeCase(
            $dto->getCaseId(),
            $dto->getUserId(),
            $now
        );
    }
}

// EOF
