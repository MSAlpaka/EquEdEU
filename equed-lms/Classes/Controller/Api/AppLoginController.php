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

        try {
            $dto = LoginRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.login.missingCredentials', JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->authService->login($dto->getEmail(), $dto->getPassword());
        if ($result === null) {
            return $this->jsonError('api.login.invalidCredentials', JsonResponse::HTTP_FORBIDDEN);
        }

        $token = $result['token'];
        $user  = $result['user'];

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
