<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\RecognitionAwardRepositoryInterface;
use Equed\EquedLms\Application\Assembler\RecognitionAwardDtoAssembler;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for recognition awards.
 *
 * Retrieves recognitions for the authenticated user.
 * Feature toggle: <recognition_api>
 */
final class RecognitionAwardController extends BaseApiController
{
    public function __construct(
        private readonly RecognitionAwardRepositoryInterface $awardRepository,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    public function listMyAwardsAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('recognition_api')) !== null) {
            return $check;
        }
        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.recognition.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }
        $awards = $this->awardRepository->findByFeUser($userId);

        $data = RecognitionAwardDtoAssembler::fromEntities($awards);

        return $this->jsonSuccess([
            'awards' => $data,
        ]);
    }
}
