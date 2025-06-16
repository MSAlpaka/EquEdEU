<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\SearchService;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for performing global search across entities.
 * Feature flag: <search_api>
 */
final class SearchController extends BaseApiController
{
    public function __construct(
        private readonly SearchService $searchService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    public function searchAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('search_api')) !== null) {
            return $check;
        }

        $params = $request->getQueryParams();
        $term = trim((string)($params['q'] ?? ''));

        $results = $this->searchService->search($term);

        if ($results->hasError()) {
            return $this->jsonError('api.search.tooShort', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->jsonSuccess([
            'courses'  => $results->getCourses(),
            'glossary' => $results->getGlossary(),
        ]);
    }
}
