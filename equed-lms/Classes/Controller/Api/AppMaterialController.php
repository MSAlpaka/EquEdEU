<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\MaterialServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for listing learning materials.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <materials_api> feature toggle.
 */
final class AppMaterialController extends BaseApiController
{
    public function __construct(
        private readonly MaterialServiceInterface $materialService,
        ConfigurationServiceInterface            $configurationService,
        ApiResponseServiceInterface              $apiResponseService,
        GptTranslationServiceInterface           $translationService,
    ) {
    }

    /**
     * Returns available learning materials filtered by type as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('materials_api')) !== null) {
            return $check;
        }

        $params = $request->getQueryParams();
        $type = isset($params['type']) ? (string)$params['type'] : 'pdf';

        $allowedTypes = ['pdf', 'video'];
        if (! in_array($type, $allowedTypes, true)) {
            return $this->jsonError('api.materials.invalidType', JsonResponse::HTTP_BAD_REQUEST);
        }

        $materials = $this->materialService->getMaterialsByType($type);

        return $this->jsonSuccess([
            'materials' => $materials,
        ]);
    }
}
