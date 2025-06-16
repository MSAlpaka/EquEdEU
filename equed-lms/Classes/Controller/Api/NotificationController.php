<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for managing notifications for all roles.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <notifications_api> feature toggle.
 */
final class NotificationController extends BaseApiController
{
    public function __construct(
        private readonly NotificationServiceInterface    $notificationService,
        ConfigurationServiceInterface   $configurationService,
        ApiResponseServiceInterface     $apiResponseService,
        GptTranslationServiceInterface  $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Lists notifications for the authenticated user.
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('notifications_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.notifications.unauthenticated', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $notifications = $this->notificationService->getNotificationsForUser($userId);

        return $this->jsonSuccess([
            'notifications' => $notifications,
        ]);
    }

    /**
     * Marks a notification as read for the authenticated user.
     */
    public function markAsReadAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('notifications_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.notifications.unauthenticated', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body = (array)$request->getParsedBody();
        $notificationId = isset($body['notificationId']) ? (int)$body['notificationId'] : 0;
        if ($notificationId <= 0) {
            return $this->jsonError('api.notifications.invalidId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->notificationService->markAsRead($userId, $notificationId);

        return $this->jsonSuccess([], 'api.notifications.markedAsRead');
    }
}
// End of file
