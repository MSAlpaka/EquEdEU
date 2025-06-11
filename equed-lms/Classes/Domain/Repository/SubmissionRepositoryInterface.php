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
     * Returns submissions waiting for the weekly AI analysis.
     *
     * @return Submission[]
     */
    public function findPendingForWeeklyAnalysis(): array;

    /**
     * Returns submissions pending evaluation by GPT.
     *
     * @return Submission[]
     */
    public function findPendingForEvaluation(): array;

    /**
     * Persist changes to a submission.
     */
    public function update(Submission $submission): void;

    /**
     * Fetch all submissions belonging to a specific UserCourseRecord.
     *
     * @param int $userCourseRecordUid
     * @return array<int, array{points: float|null, maxPoints: float|null}>
     */
    public function findByUserCourseRecord(int $userCourseRecordUid): array;
}
