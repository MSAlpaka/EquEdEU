<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Service to retrieve QMS cases for Service Center API operations.
 */
final class ServiceCenterCaseService
{
    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    /**
     * Fetch all QMS cases ordered by submission date.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getQmsCases(): array
    {
        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_qms');

        return $qb
            ->select('*')
            ->from('tx_equedlms_domain_model_qms')
            ->where($qb->expr()->eq('deleted', 0))
            ->orderBy('submitted_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}

// EOF
