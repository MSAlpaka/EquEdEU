<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseBundleServiceInterface;

/**
 * API controller for listing available course bundles and their status for the authenticated user.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_bundle_api> feature toggle.
 */
final class CourseBundleController
{
    public function __construct(
        private readonly CourseBundleServiceInterface    $bundleService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService,
        private readonly Context                         $context
    ) {
    }

    /**
     * Returns available course bundles for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function listAvailableAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('course_bundle_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseBundle.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseBundle.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $bundles = $this->bundleService->getAvailableBundles($userId);

        return new JsonResponse([
            'status'  => 'success',
            'bundles' => $bundles,
        ]);
    }
}
// End of file
