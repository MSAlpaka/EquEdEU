<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

/**
 * Low level repository for direct QMS case table access.
 */
interface QmsCaseRecordRepositoryInterface
{
    /**
     * Fetch all QMS cases submitted by a user.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findByUserId(int $userId): array;

    /**
     * Fetch all QMS cases ordered by submission date.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAll(): array;

    public function addCase(int $userId, int $recordId, string $type, string $message, int $timestamp): void;

    public function respondToCase(int $caseId, int $userId, string $role, string $response, int $timestamp): void;

    public function closeCase(int $caseId, int $userId, int $timestamp): void;
}
