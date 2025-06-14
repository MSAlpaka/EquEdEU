<?php

declare(strict_types=1);

namespace Equed\EquedLms\Scheduler;

use Equed\EquedLms\Domain\Service\BadgeAwardServiceInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Scheduler task to award pending badges for completed courses and learning paths.
 */
final class BadgeAwardTask extends AbstractTask implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly BadgeAwardServiceInterface $badgeAwardService,
        ObjectManagerInterface $objectManager = null
    ) {
        parent::__construct($objectManager);
    }

    /**
     * Executes the badge awarding process.
     *
     * @return bool Always returns true to indicate the scheduler should consider the task successful.
     */
    public function execute(): bool
    {
        $newBadges = $this->badgeAwardService->awardPendingBadges();

        $message = sprintf('Awarded %d new badge(s)', $newBadges);
        $this->logger?->info($message);

        $this->addMessage($message, FlashMessage::OK);

        return true;
    }
}
// EOF

