<?php

declare(strict_types=1);

namespace Equed\EquedLms\Task;

use Equed\EquedLms\Service\ProgressServiceInterface;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to clean up abandoned course progress.
 */
final class ProgressCleanupTask extends AbstractTask
{
    private const ABANDONMENT_THRESHOLD_DAYS = 60;

    public function __construct(
        private readonly ProgressServiceInterface $progressService
    ) {
    }

    /**
     * Executes the cleanup of course progress older than the threshold.
     *
     * @return bool True on successful execution
     */
    public function execute(): bool
    {
        $this->progressService->cleanupAbandonedCourseProgress(
            self::ABANDONMENT_THRESHOLD_DAYS
        );

        return true;
    }
}
// End of file
