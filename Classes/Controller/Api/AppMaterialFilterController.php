<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\MaterialServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for filtering and listing learning materials.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * to leverage hybrid live-translation with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <materials_api> feature toggle.
 */
final class AppMaterialFilterController
{
    public function __construct(
        private readonly MaterialServiceInterface      $materialService,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Returns available learning materials filtered by type as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('materials_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.materials.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $params = $request->getQueryParams();
        $type = isset($params['type']) ? (string)$params['type'] : 'pdf';

        $allowedTypes = ['pdf', 'video'];
        if (!in_array($type, $allowedTypes, true)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.materials.invalidType')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $materials = $this->materialService->getMaterialsByType($type);

        return new JsonResponse([
            'status'    => 'success',
            'materials' => $materials,
        ]);
    }
}
// EOF
