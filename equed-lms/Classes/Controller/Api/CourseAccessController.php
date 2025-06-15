<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseAccessServiceInterface;
use Equed\EquedLms\Dto\CourseAccessRequest;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for checking user eligibility for a course program.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_access_api> feature toggle.
 */
final class CourseAccessController extends BaseApiController
{
    public function __construct(
        private readonly CourseAccessServiceInterface $accessService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
        private readonly Context $context,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
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
        if (($check = $this->requireFeature('course_access_api')) !== null) {
            return $check;
        }

        $dto = CourseAccessRequest::fromRequest($request);

        if ($dto->getUserId() <= 0) {
            return $this->jsonError('api.courseAccess.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($dto->getCourseProgramId() <= 0) {
            return $this->jsonError('api.courseAccess.invalidProgram', JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->accessService->checkCourseProgramAccess($dto);

        return $this->jsonSuccess([
            'access' => $result->isGranted(),
        ]);
    }
}
// End of file
