<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseBundleServiceInterface;

/**
 * API controller for listing available course bundles and their status for the authenticated user.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_bundle_api> feature toggle.
 */
final class CourseBundleController extends BaseApiController
{
    public function __construct(
        private readonly CourseBundleServiceInterface    $bundleService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Returns available course bundles for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listAvailableAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('course_bundle_api')) !== null) {
            return $check;
        }
        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.courseBundle.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $bundles = $this->bundleService->getAvailableBundles($userId);

        return $this->jsonSuccess(['bundles' => $bundles]);
    }
}
