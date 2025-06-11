<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseAccessMapServiceInterface;

/**
 * API controller for retrieving the mapping of course programs to their prerequisite goals.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_access_map_api> feature toggle.
 */
final class CourseAccessMapController
{
    public function __construct(
        private readonly CourseAccessMapServiceInterface    $accessMapService,
        private readonly ConfigurationServiceInterface      $configurationService,
        private readonly GptTranslationServiceInterface     $translationService
    ) {
    }

    /**
     * Returns the course-access map as JSON.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function mapAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('course_access_map_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseAccessMap.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $map = $this->accessMapService->getCourseAccessMap();

        return new JsonResponse([
            'status'    => 'success',
            'accessMap' => $map,
        ]);
    }
}
// EOF
