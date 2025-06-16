<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides CRUD operations for user course record API endpoints.
 */
interface UserCourseRecordCrudServiceInterface
{
    /**
     * Retrieve all records for a given frontend user.
     *
     * @return array<int, array<string, mixed>>
     */
    public function listForUser(int $userId): array;

    /**
     * Retrieve a single record belonging to the user or null if not found.
     *
     * @return array<string, mixed>|null
     */
    public function getForUser(int $userId, int $recordId): ?array;

    /**
     * Update a record with the given field values.
     *
     * @param array<string, mixed> $fields
     */
    public function updateRecord(int $userId, int $recordId, array $fields): void;

    /**
     * Soft delete a record for the user.
     */
    public function deleteRecord(int $userId, int $recordId): void;
}
