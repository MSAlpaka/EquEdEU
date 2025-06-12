<?php

declare(strict_types=1);

namespace Equed\EquedLms\Task;

use TYPO3\CMS\Scheduler\Task\AbstractTask;
use Equed\EquedLms\Service\CertificateService;

/**
 * Scheduler task to dispatch certificates in queue.
 */
final class CertificateDispatchTask extends AbstractTask
{
    public function __construct(
        private readonly CertificateService $certificateService
    ) {
    }

    /**
     * Executes the dispatch of pending certificates.
     *
     * @return bool True on successful execution
     */
    public function execute(): bool
    {
        $this->certificateService->processDispatchQueue();

        return true;
    }
}
// EOF
