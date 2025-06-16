<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Lesson\LessonCompletedEvent;
use Equed\EquedLms\Domain\Service\BadgeAwardServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Awards badges when lessons are completed.
 */
final class BadgeAwardListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(
        protected readonly BadgeAwardServiceInterface $badgeAwardService
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LessonCompletedEvent::class => 'onLessonCompleted',
        ];
    }

    public function onLessonCompleted(LessonCompletedEvent $event): void
    {
        // Simple example: trigger badge evaluation for completed lessons
        $this->badgeAwardService->awardPendingBadges();
    }
}

