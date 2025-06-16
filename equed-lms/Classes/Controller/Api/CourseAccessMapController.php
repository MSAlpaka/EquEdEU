<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\CourseAccessMapServiceInterface;

/**
 * API controller for retrieving the mapping of course programs to their prerequisite goals.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_access_map_api> feature toggle.
 */
final class CourseAccessMapController extends BaseApiController
{
    public function __construct(
        private readonly CourseAccessMapServiceInterface $accessMapService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Returns the course-access map as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function mapAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('course_access_map_api')) !== null) {
            return $check;
        }

        $map = $this->accessMapService->getCourseAccessMap();

        return $this->jsonSuccess([
            'accessMap' => $map,
        ]);
    }
}
