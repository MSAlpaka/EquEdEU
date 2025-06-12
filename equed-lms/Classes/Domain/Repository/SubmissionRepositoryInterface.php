<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Submission;

interface SubmissionRepositoryInterface
{
    /**
     * Find a submission by its UID.
     */
    public function findByUid(int $uid): ?Submission;

    /**
     * Returns submissions pending GPT analysis.
     *
     * @return Submission[]
     */
    public function findPendingForAnalysis(): array;

    /**
     * Persist changes to a submission.
     */
    public function update(Submission $submission): void;

}
