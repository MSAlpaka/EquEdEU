<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\CourseProgramRepositoryInterface;

/**
 * Repository for CourseProgram entities.
 *
 * @extends Repository<CourseProgram>
 */
final class CourseProgramRepository extends Repository implements CourseProgramRepositoryInterface
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
     * Find a course program by its UUID.
     *
     * @param string $uuid
     * @return CourseProgram|null
     */
    public function findByUuid(string $uuid): ?CourseProgram
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
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
     * Find all active course programs.
     *
     * Active programs are visible, not archived and available now.
     *
     * @return CourseProgram[]
     */
    public function findActive(): array
    {
        $now = new \DateTimeImmutable();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('isVisible', true),
                $query->equals('isArchived', false),
                $query->lessThanOrEqual('availableFrom', $now),
            ])
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

    /**
     * Find all active programs for the given category.
     *
     * Active programs are visible, not archived and available now.
     *
     * @param string $category
     * @return CourseProgram[]
     */
    public function findActiveByCategory(string $category): array
    {
        $now = new \DateTimeImmutable();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('category', $category),
                $query->equals('isVisible', true),
                $query->equals('isArchived', false),
                $query->lessThanOrEqual('availableFrom', $now),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Count all active programs.
     *
     * Active programs are visible, not archived and available now.
     *
     * @return int
     */
    public function countActivePrograms(): int
    {
        $now = new \DateTimeImmutable();

        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_courseprogram')
            ->where(
                $qb->expr()->eq('is_visible', $qb->createNamedParameter(true, \PDO::PARAM_BOOL)),
                $qb->expr()->eq('is_archived', $qb->createNamedParameter(false, \PDO::PARAM_BOOL)),
                $qb->expr()->lte('available_from', $qb->createNamedParameter($now->format('Y-m-d H:i:s')))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }
}
