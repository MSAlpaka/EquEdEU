<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\FeedbackServiceInterface;
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
        parent::__construct($configurationService, $apiResponseService, $translationService);
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

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $feedback = isset($body['feedback']) ? trim((string)$body['feedback']) : '';
        $standardsOk = isset($body['standardsOk']) ? (bool)$body['standardsOk'] : false;
        $suggestedCourses = isset($body['suggestedCourses']) ? (string)$body['suggestedCourses'] : '';
        $ratingInstructor = isset($body['ratingInstructor']) ? (int)$body['ratingInstructor'] : 0;
        $ratingLocation = isset($body['ratingLocation']) ? (int)$body['ratingLocation'] : 0;

        if ($recordId <= 0 || $feedback === '') {
            return $this->jsonError('api.feedback.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->feedbackService->submitFeedback(
            userId: $userId,
            recordId: $recordId,
            feedbackText: $feedback,
            standardsOk: $standardsOk,
            suggestedCourses: $suggestedCourses,
            ratingInstructor: $ratingInstructor,
            ratingLocation: $ratingLocation
        );

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
// EOF
