<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseAccessServiceInterface;

/**
 * API controller for checking user eligibility for a course program.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_access_api> feature toggle.
 */
final class CourseAccessController
{
    public function __construct(
        private readonly CourseAccessServiceInterface     $accessService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface   $translationService,
        private readonly Context                          $context
    ) {
    }

    /**
     * Checks if the authenticated user meets prerequisites for a course program.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function checkAccessAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('course_access_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccess.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccess.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $programId = isset($params['programId']) ? (int)$params['programId'] : 0;
        if ($programId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccess.invalidProgram')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $accessData = $this->accessService->checkAccess($userId, $programId);

        return new JsonResponse([
            'status' => 'success',
            'access' => $accessData,
        ]);
    }
}
// End of file
