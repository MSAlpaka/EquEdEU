<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;

/**
 * Service to retrieve QMS cases for Service Center API operations.
 */
final class ServiceCenterCaseService
{
    public function __construct(private readonly QmsCaseRecordRepositoryInterface $repository)
    {
    }

    /**
     * Fetch all QMS cases ordered by submission date.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getQmsCases(): array
    {
        return $this->repository->findAll();
    }
}

// EOF
