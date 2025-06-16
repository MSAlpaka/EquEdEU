<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CourseProgramRepositoryInterface
{
    /**
     * @param int $uid
     * @return CourseProgram|null
     */
    public function findByUid(int $uid): ?CourseProgram;

    /**
     * @param string $uuid
     * @return CourseProgram|null
     */
    public function findByUuid(string $uuid): ?CourseProgram;

    /**
     * @return CourseProgram[]
     */
    public function findVisible(): array;

    /**
     * @return CourseProgram[]
     */
    public function findActive(): array;

    /**
     * @param string $category
     * @return CourseProgram[]
     */
    public function findByCategory(string $category): array;

    /**
     * @param string $category
     * @return CourseProgram[]
     */
    public function findActiveByCategory(string $category): array;

    public function countActivePrograms(): int;

    /**
     * @return QueryInterface<CourseProgram>
     */
    public function createQuery(): QueryInterface;
}

