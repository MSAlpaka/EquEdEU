<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\Core\Service\PasswordHasherInterface;
use Equed\EquedLms\Domain\Repository\UserRepositoryInterface;
use Equed\EquedLms\Domain\Service\JwtServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for user authentication: login, logout, and profile.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <login_api> feature toggle.
 */
final class AuthController
{
    public function __construct(
        private readonly UserRepositoryInterface        $userRepository,
        private readonly JwtServiceInterface            $jwtService,
        private readonly PasswordHasherInterface        $passwordHasher,
        private readonly ConfigurationServiceInterface  $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
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
        if (!$this->configurationService->isFeatureEnabled('login_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $data = (array)$request->getParsedBody();
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if ($email === '' || $password === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.missingCredentials')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $user = $this->userRepository->findOneByEmail($email);
        if ($user === null || !$this->passwordHasher->verify($password, $user->getPasswordHash())) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.invalidCredentials')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $token = $this->jwtService->generateToken($user);
        $roles = array_map(
            static fn ($group) => $group->getUid(),
            $user->getUserGroups()->toArray()
        );

        return new JsonResponse([
            'status'  => 'success',
            'token'   => $token,
            'userId'  => $user->getUid(),
            'name'    => $user->getName(),
            'email'   => $user->getEmail(),
            'roles'   => $roles,
        ]);
    }

    /**
     * Logs out the user (client should discard token).
     *
     * @return JsonResponse
     */
    public function logoutAction(): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('login_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.auth.loggedOut'),
        ]);
    }

    /**
     * Returns the current authenticated user's profile.
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function meAction(): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('login_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $userContext = $request->getAttribute('user');
        if (!is_array($userContext) || !isset($userContext['uid'])) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $userId = (int)$userContext['uid'];
        $user = $this->userRepository->findByUid($userId);
        if ($user === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.auth.notFound')],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $roles = array_map(
            static fn ($group) => $group->getUid(),
            $user->getUserGroups()->toArray()
        );

        return new JsonResponse([
            'status' => 'success',
            'userId' => $user->getUid(),
            'name'   => $user->getName(),
            'email'  => $user->getEmail(),
            'roles'  => $roles,
        ]);
    }
}
// End of file
