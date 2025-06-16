<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\UserAccountServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for retrieving the authenticated user's profile.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <user_profile_api> feature toggle.
 */
final class AppUserController extends BaseApiController
{
    public function __construct(
        private readonly UserAccountServiceInterface     $accountService,
        ConfigurationServiceInterface                    $configurationService,
        ApiResponseServiceInterface                      $apiResponseService,
        GptTranslationServiceInterface                   $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Returns the current user's profile as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function profileAction(ServerRequestInterface $request): JsonResponse
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

        $roles = array_filter(array_map('intval', explode(',', (string)($profile['usergroup'] ?? ''))));

        return $this->jsonSuccess([
            'userId'           => (int)$profile['uid'],
            'name'             => (string)($profile['name'] ?? ''),
            'email'            => (string)($profile['email'] ?? ''),
            'roles'            => $roles,
            'profileCompleted' => trim((string)($profile['name'] ?? '')) !== '',
        ]);
    }
}
// End of file
