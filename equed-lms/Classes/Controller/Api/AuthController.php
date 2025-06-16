<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\AuthenticationServiceInterface;
use Equed\EquedLms\Dto\LoginRequest;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for user authentication: login, logout, and profile.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <login_api> feature toggle.
 */
final class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authService,
        ConfigurationServiceInterface                  $configurationService,
        ApiResponseServiceInterface                    $apiResponseService,
        GptTranslationServiceInterface                 $translationService,
    ) {
    }

    /**
     * Authenticates the user and returns a JWT token.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function loginAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('login_api')) !== null) {
            return $check;
        }

        try {
            $dto = LoginRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.auth.missingCredentials', JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->authService->login($dto->getEmail(), $dto->getPassword());
        if ($result === null) {
            return $this->jsonError('api.auth.invalidCredentials', JsonResponse::HTTP_UNAUTHORIZED);
        }
        $token = $result['token'];
        $user  = $result['user'];

        return $this->jsonSuccess([
            'token'  => $token,
            'userId' => $user->getUid(),
            'name'   => $user->getName(),
            'email'  => $user->getEmail(),
            'roles'  => array_map(
                static fn ($group) => $group->getUid(),
                $user->getUserGroups()->toArray(),
            ),
        ]);
    }

    /**
     * Logs out the user (client should discard token).
     *
     * @return JsonResponse
     */
    public function logoutAction(): JsonResponse
    {
        if (($check = $this->requireFeature('login_api')) !== null) {
            return $check;
        }

        $this->authService->logout();

        return $this->jsonSuccess([
            'message' => $this->translationService->translate('api.auth.loggedOut'),
        ]);
    }

    /**
     * Returns the current authenticated user's profile.
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function meAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('login_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.auth.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = $this->authService->getUserById($userId);
        if ($user === null) {
            return $this->jsonError('api.auth.notFound', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->jsonSuccess([
            'userId' => $user->getUid(),
            'name'   => $user->getName(),
            'email'  => $user->getEmail(),
            'roles'  => array_map(
                static fn ($group) => $group->getUid(),
                $user->getUserGroups()->toArray(),
            ),
        ]);
    }
}
