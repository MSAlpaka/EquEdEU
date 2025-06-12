<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for LearningPath entities.

 *
 * @extends Repository<LearningPath>
 */
final class LearningPathRepository extends Repository
{
    /**
     * Default ordering: first by level, then by title.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'level' => QueryInterface::ORDER_ASCENDING,
        'title' => QueryInterface::ORDER_ASCENDING,
    ];
}
// EOF
