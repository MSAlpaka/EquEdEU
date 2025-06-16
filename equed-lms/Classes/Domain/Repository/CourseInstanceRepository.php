<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use InvalidArgumentException;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseInstance entities.
 *
 * @extends Repository<CourseInstance>
 */
final class CourseInstanceRepository extends Repository implements CourseInstanceRepositoryInterface
{
    /**
     * List of columns allowed for distinct lookup.
     *
     * @var string[]
     */
    private const ALLOWED_COLUMNS = ['theme', 'language', 'eqfLevel'];

    /**
     * Find instances that require an external examiner but don't have one yet.
     *
     * @return CourseInstance[]
     */
    public function findAllRequiringExternalExaminer(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('requiresExternalExaminer', true),
                $query->equals('externalExaminer', null),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Return distinct values for a database field.
     *
     * @param string $field Database field name
     * @return array<int, mixed>
     */
    public function findDistinctField(string $field): array
    {
        if (!in_array($field, self::ALLOWED_COLUMNS, true)) {
            throw new InvalidArgumentException(sprintf('Column "%s" is not allowed', $field));
        }

        $column = $field;
        $queryBuilder = $this->createQuery()->getQueryBuilder();
        $rows = $queryBuilder
            ->selectDistinct($column)
            ->from('tx_equedlms_domain_model_courseinstance')
            ->executeQuery()
            ->fetchFirstColumn();

        return array_values(array_filter($rows, static fn ($v) => $v !== null && $v !== ''));
    }
}
