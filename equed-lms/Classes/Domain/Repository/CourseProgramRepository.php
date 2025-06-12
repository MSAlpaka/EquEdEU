<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseProgram entities.
 *
 * @extends Repository<CourseProgram>
 */
class CourseProgramRepository extends Repository
{
    /**
     * Find a course program by UID.
     *
     * @param int $uid
     * @return CourseProgram|null
     */
    public function findByUid(int $uid): ?CourseProgram
    {
        return $this->findByIdentifier($uid);
    }

    /**
     * Find all visible course programs.
     *
     * @return CourseProgram[]
     */
    public function findVisible(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isVisible', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course programs by category.
     *
     * @param string $category
     * @return CourseProgram[]
     */
    public function findByCategory(string $category): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('category', $category)
        );

        return $query->execute()->toArray();
    }
}
