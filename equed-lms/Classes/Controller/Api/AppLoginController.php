<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\AuthenticationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for user authentication.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Interacts with domain models via repository interfaces and uses DI.
 */
final class AppLoginController extends BaseApiController
{
    public function __construct(
        private readonly AuthenticationServiceInterface $authService,
        ConfigurationServiceInterface                  $configurationService,
        ApiResponseServiceInterface                    $apiResponseService,
        GptTranslationServiceInterface                 $translationService
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
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
        if (($check = $this->requireFeature('login_api')) !== null) {
            return $check;
        }

        $body     = (array)$request->getParsedBody();
        $email    = trim($body['email'] ?? '');
        $password = $body['password'] ?? '';

        if ($email === '' || $password === '') {
            return $this->jsonError('api.login.missingCredentials', JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->authService->validateCredentials($email, $password);
        if ($user === null) {
            return $this->jsonError('api.login.invalidCredentials', JsonResponse::HTTP_FORBIDDEN);
        }

        $token = $this->authService->createToken($user);

        return $this->jsonSuccess([
            'token'  => $token,
            'userId' => $user->getUid(),
            'name'   => $user->getName(),
            'roles'  => array_map(
                static fn ($group) => $group->getUid(),
                $user->getUserGroups()->toArray()
            ),
        ]);
    }
}
// End of file
