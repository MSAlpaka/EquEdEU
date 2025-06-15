<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for retrieving the authenticated user's profile.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <user_profile_api> feature toggle.
 */
final class AppUserController
{
    public function __construct(
        private readonly UserRepositoryInterface         $userRepository,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService,
    ) {
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
        if (!$this->configurationService->isFeatureEnabled('user_profile_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.userProfile.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $userContext = $request->getAttribute('user');
        if (!is_array($userContext) || !isset($userContext['uid'])) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.userProfile.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $userId = (int)$userContext['uid'];
        $user = $this->userRepository->findByUid($userId);

        if ($user === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.userProfile.notFound')],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $roles = array_map(
            static fn ($group) => $group->getUid(),
            $user->getUserGroups()->toArray()
        );

        return new JsonResponse([
            'status'           => 'success',
            'userId'           => $user->getUid(),
            'name'             => $user->getName(),
            'email'            => $user->getEmail(),
            'roles'            => $roles,
            'profileCompleted' => !empty($user->getName()),
        ]);
    }
}
// End of file
