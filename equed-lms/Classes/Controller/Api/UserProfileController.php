<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\UserAccountServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * UserProfileController
 *
 * Manages user profile retrieval and updates via API.
 */
final class UserProfileController extends BaseApiController
{
    public function __construct(
        private readonly UserAccountServiceInterface $accountService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Get current user profile.
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('user_profile_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.userProfile.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $profile = $this->accountService->getProfile($userId);
        if ($profile === null) {
            return $this->jsonError('api.userProfile.notFound', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->jsonSuccess(['profile' => $profile]);
    }

    /**
     * Update current user profile.
     */
    public function updateAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('user_profile_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.userProfile.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body   = (array) $request->getParsedBody();
        $fields = [];
        $allowed = ['name', 'email'];
        foreach ($allowed as $field) {
            if (isset($body[$field]) && is_string($body[$field])) {
                $fields[$field] = trim($body[$field]);
            }
        }

        if ($fields === []) {
            return $this->jsonError('api.userProfile.noFields', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->accountService->updateProfile($userId, $fields);

        return $this->jsonSuccess([], 'api.userProfile.updated');
    }
}
// End of file
