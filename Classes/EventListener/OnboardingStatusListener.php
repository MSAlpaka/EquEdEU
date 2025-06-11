<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\User\OnboardingCompletedEvent;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Listens for onboarding completion events and logs the completion.
 */
final class OnboardingStatusListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(
        protected readonly LogService $logService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            OnboardingCompletedEvent::class => 'onOnboardingCompleted',
        ];
    }

    /**
     * Handle the OnboardingCompletedEvent.
     *
     * @param OnboardingCompletedEvent $event
     */
    public function onOnboardingCompleted(OnboardingCompletedEvent $event): void
    {
        $profile = $event->getUserProfile();
        $this->logService->logInfo(
            'Onboarding completed',
            [
                'user'   => $profile->getFeUser()?->getUid(),
                'region' => $profile->getRegion()?->getTitle(),
            ]
        );
    }
}
// EOF
