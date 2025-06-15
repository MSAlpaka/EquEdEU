<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseOverviewServiceInterface;

/**
 * API controller for providing course overview data:
 * available programs, active instances, and user's courses.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_overview_api> feature toggle.
 */
final class CourseOverviewController extends BaseApiController
{
    public function __construct(
        private readonly CourseOverviewServiceInterface $overviewService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Returns course overview data as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function indexAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('course_overview_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.courseOverview.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $overview = $this->overviewService->getCourseOverview($userId);

        return $this->jsonSuccess($overview);
    }
}
// End of file
