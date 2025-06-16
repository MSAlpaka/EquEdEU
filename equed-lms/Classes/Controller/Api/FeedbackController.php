<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\FeedbackServiceInterface;
use Equed\EquedLms\Dto\FeedbackRequest;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for submitting and checking feedback on course records.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <feedback_api> feature toggle.
 */
final class FeedbackController extends BaseApiController
{
    public function __construct(
        private readonly FeedbackServiceInterface $feedbackService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Submits feedback for a specific user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function submitAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('feedback_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.feedback.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $dto = FeedbackRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.feedback.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->feedbackService->submitFeedback($dto);

        return $this->jsonSuccess([
            'message' => $this->translationService->translate('api.feedback.submitted'),
        ]);
    }

    /**
     * Checks whether feedback has been submitted for a user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function checkAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('feedback_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.feedback.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params = $request->getQueryParams();
        $recordId = isset($params['recordId']) ? (int)$params['recordId'] : 0;
        if ($recordId <= 0) {
            return $this->jsonError('api.feedback.invalidRecordId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $submitted = $this->feedbackService->isFeedbackSubmitted($userId, $recordId);

        return $this->jsonSuccess([
            'feedbackSubmitted' => $submitted,
        ]);
    }
}
