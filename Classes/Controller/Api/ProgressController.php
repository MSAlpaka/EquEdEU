<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ProgressCalculationServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for calculating course progress.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <progress_api> feature toggle.
 */
final class ProgressController extends ActionController
{
    public function __construct(
        private readonly ProgressCalculationServiceInterface $progressService,
        private readonly ConfigurationServiceInterface       $configurationService,
        private readonly GptTranslationServiceInterface      $translationService,
        private readonly Context                             $context
    ) {
        parent::__construct();
    }

    /**
     * Returns progress for a given user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function getCourseProgressAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('progress_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params   = $request->getQueryParams();
        $recordId = isset($params['recordId']) ? (int)$params['recordId'] : 0;
        if ($recordId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.invalidRecordId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $progress = $this->progressService->calculateProgress($userId, $recordId);

        return new JsonResponse([
            'status'   => 'success',
            'progress' => $progress,
        ]);
    }
}
// EOF
