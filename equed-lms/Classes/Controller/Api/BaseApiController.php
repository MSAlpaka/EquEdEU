<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Base controller for API endpoints providing common helpers.
 */
abstract class BaseApiController extends ActionController
{
    public function __construct(
        protected readonly ConfigurationServiceInterface $configurationService,
        protected readonly ApiResponseServiceInterface $apiResponseService,
        protected readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Ensures a feature is enabled.
     *
     * Returns a {@see JsonResponse} if the feature is disabled.
     */
    protected function requireFeature(string $featureKey): ?JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled($featureKey)) {
            return $this->jsonError('api.' . $featureKey . '.disabled', JsonResponse::HTTP_FORBIDDEN);
        }

        return null;
    }

    /**
     * Retrieves the current frontend user identifier.
     */
    protected function getCurrentUserId(ServerRequestInterface $request): ?int
    {
        $user = $request->getAttribute('user');

        return is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
    }

    /**
     * Builds a standardized success response.
     *
     * @param array<string, mixed> $data
     */
    protected function jsonSuccess(array $data = [], string $messageKey = 'ok'): JsonResponse
    {
        $lang = $this->translationService->getDefaultLanguage();
        $payload = $this->apiResponseService->success($data, $messageKey, $lang);

        return new JsonResponse($payload, JsonResponse::HTTP_OK);
    }

    /**
     * Builds a standardized error response.
     */
    protected function jsonError(string $messageKey, int $status): JsonResponse
    {
        $lang = $this->translationService->getDefaultLanguage();
        $payload = $this->apiResponseService->error($messageKey, $status, $lang);

        return new JsonResponse($payload, $status);
    }
}
