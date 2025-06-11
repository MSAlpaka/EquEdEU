<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Domain\Repository\QmsCaseRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Service for retrieving and managing QMS cases.
 */
final class QmsService
{
    public function __construct(
        private readonly QmsCaseRepositoryInterface $qmsCaseRepository,
        private readonly PersistenceManagerInterface $persistenceManager
    ) {
    }

    /**
     * Get all open QMS cases.
     *
     * @return QmsCase[]
     */
    public function getOpenCases(): array
    {
        return $this->qmsCaseRepository->findOpenCases();
    }

    /**
     * Get all QMS cases assigned to a specific instructor.
     *
     * @param int $instructorFeUser FE user ID of instructor
     * @return QmsCase[]
     */
    public function getCasesByInstructor(int $instructorFeUser): array
    {
        return $this->qmsCaseRepository->findByInstructor($instructorFeUser);
    }

    /**
     * Mark a QMS case as escalated.
     *
     * @param int $caseId Unique identifier of the QMS case
     * @return bool True if case found and updated, false otherwise
     */
    public function escalateCase(int $caseId): bool
    {
        $case = $this->qmsCaseRepository->findByUid($caseId);
        if ($case === null) {
            return false;
        }

        $case->setEscalated(true);
        $this->qmsCaseRepository->update($case);
        $this->persistenceManager->persistAll();

        return true;
    }
}
