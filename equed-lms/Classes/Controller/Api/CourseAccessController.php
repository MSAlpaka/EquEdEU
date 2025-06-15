<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseAccessServiceInterface;
use Equed\EquedLms\Dto\CourseAccessRequest;
use Equed\EquedLms\Dto\CourseAccessResult;

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

        $dto = CourseAccessRequest::fromRequest($request);

        if ($dto->getUserId() <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccess.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        if ($dto->getCourseProgramId() <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccess.invalidProgram')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $result = $this->accessService->checkCourseProgramAccess($dto);

        return new JsonResponse([
            'status' => 'success',
            'access' => $result->isGranted(),
        ]);
    }
}
// End of file
