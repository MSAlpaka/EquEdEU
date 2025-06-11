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
 * API controller for user authentication.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Interacts with domain models via repository interfaces and uses DI.
 */
final class AppLoginController
{
    public function __construct(
        private readonly UserRepositoryInterface        $userRepository,
        private readonly JwtServiceInterface            $jwtService,
        private readonly PasswordHasherInterface        $passwordHasher,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly ConfigurationServiceInterface  $configurationService
    ) {
    }

    /**
     * Authenticates the user and returns a JWT.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function loginAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('login_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.login.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $body = (array)$request->getParsedBody();
        $email = trim($body['email'] ?? '');
        $password = $body['password'] ?? '';

        if ($email === '' || $password === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.login.missingCredentials')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $user = $this->userRepository->findOneByEmail($email);
        if ($user === null || !$this->passwordHasher->verify($password, $user->getPasswordHash())) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.login.invalidCredentials')],
                JsonResponse::HTTP_FORBIDDEN
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
            'roles'   => $roles,
        ]);
    }
}
// End of file
