<?php

declare(strict_types=1);

namespace Equed\EquedLms\Task;

use Equed\EquedLms\Service\SubmissionService;
use Equed\EquedLms\Service\LogService;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to flag unreviewed submissions older than a threshold.
 */
final class SubmissionReviewTask extends AbstractTask
{
    private const REVIEW_THRESHOLD_DAYS = 14;

    public function __construct(
        private readonly SubmissionService $submissionService,
        private readonly LogService $logService
    ) {
    }

    /**
     * Executes the review check for pending submissions.
     *
     * @return bool True on successful execution
     */
    public function execute(): bool
    {
        $pending = $this->submissionService->getUnreviewedSubmissionsOlderThan(
            self::REVIEW_THRESHOLD_DAYS
        );

        foreach ($pending as $submission) {
            $this->logService->logWarning(
                'Unreviewed submission flagged',
                ['submissionId' => $submission->getUid()]
            );
        }

        return true;
    }
}
// End of file
