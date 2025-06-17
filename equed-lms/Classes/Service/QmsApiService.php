<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\QmsSubmitRequest;
use Equed\EquedLms\Dto\QmsRespondRequest;
use Equed\EquedLms\Dto\QmsCloseRequest;

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
     * @return array<int, array<string, mixed>>
     */
    public function getCasesForUser(int $userId): array
    {
        return $this->repository->findByUserId($userId);
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
