<?php

declare(strict_types=1);

namespace Equed\EquedLms\Task;

use Equed\EquedLms\Domain\Service\InstructorServiceInterface;
use Equed\EquedLms\Service\LogService;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to log inactive instructors based on activity threshold.
 */
final class InstructorActivityTask extends AbstractTask
{
    private const INACTIVITY_THRESHOLD_DAYS = 90;

    public function __construct(
        private readonly InstructorServiceInterface $instructorService,
        private readonly LogService $logService
    ) {
    }

    /**
     * Executes the task.
     *
     * @return bool True on successful execution
     */
    public function execute(): bool
    {
        $inactiveInstructors = $this->instructorService->getInactiveInstructorList(
            self::INACTIVITY_THRESHOLD_DAYS
        );

        foreach ($inactiveInstructors as $instructor) {
            $this->logService->logWarning(
                'Inactive instructor identified',
                ['instructorId' => $instructor->getUid()]
            );
        }

        return true;
    }
}
// End of file
