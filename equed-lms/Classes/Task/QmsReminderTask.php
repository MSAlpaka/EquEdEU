<?php

declare(strict_types=1);

namespace Equed\EquedLms\Task;

use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Service\QmsServiceInterface;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to send reminders for open QMS cases.
 */
final class QmsReminderTask extends AbstractTask
{
    public function __construct(
        private readonly QmsServiceInterface $qmsService,
        private readonly MailServiceInterface $mailService
    ) {
    }

    /**
     * Executes the reminder sending for open QMS cases.
     *
     * @return bool True on successful execution
     */
    public function execute(): bool
    {
        $openCases = $this->qmsService->getOpenCasesForReminder();

        foreach ($openCases as $case) {
            $email = $case->getAssignedCertifier()?->getEmail();
            if ($email !== null) {
                $this->mailService->sendQmsReminder($email, $case->getUid());
            }
        }

        return true;
    }
}
// End of file
