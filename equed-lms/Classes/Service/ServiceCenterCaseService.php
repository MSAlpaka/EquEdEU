<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;
use Equed\EquedLms\Dto\QmsCaseDto;

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
     * @return array<int, QmsCaseDto>
     */
    public function getQmsCases(): array
    {
        $rows = $this->repository->findAll();

        return array_map(
            fn (array $row): QmsCaseDto => new QmsCaseDto(
                (int)$row['uid'],
                (int)$row['usercourserecord'],
                (string)$row['type'],
                (string)$row['message'],
                (string)$row['status'],
                (int)$row['submitted_at'],
                isset($row['responded_at']) ? (int)$row['responded_at'] : null,
                isset($row['closed_at']) ? (int)$row['closed_at'] : null,
            ),
            $rows
        );
    }
}

// EOF
