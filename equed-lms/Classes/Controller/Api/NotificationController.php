<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for managing notifications for all roles.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <notifications_api> feature toggle.
 */
final class NotificationController extends ActionController
{
    public function __construct(
        private readonly NotificationServiceInterface    $notificationService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService,
    ) {
        parent::__construct();
    }

    /**
     * Lists notifications for the authenticated user.
     */
    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('notifications_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.notifications.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.notifications.unauthenticated')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $notifications = $this->notificationService->getNotificationsForUser($userId);

        return new JsonResponse([
            'status'        => 'success',
            'notifications' => $notifications,
        ]);
    }

    /**
     * Marks a notification as read for the authenticated user.
     */
    public function markAsReadAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('notifications_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.notifications.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.notifications.unauthenticated')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $notificationId = isset($body['notificationId']) ? (int)$body['notificationId'] : 0;
        if ($notificationId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.notifications.invalidId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->notificationService->markAsRead($userId, $notificationId);

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.notifications.markedAsRead'),
        ]);
    }
}
// End of file
