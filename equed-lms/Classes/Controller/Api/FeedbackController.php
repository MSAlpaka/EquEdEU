<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\FeedbackServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for submitting and checking feedback on course records.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <feedback_api> feature toggle.
 */
final class FeedbackController extends ActionController
{
    public function __construct(
        private readonly FeedbackServiceInterface        $feedbackService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService,
        private readonly Context                         $context
    ) {
        parent::__construct();
    }

    /**
     * Submits feedback for a specific user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function submitAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('feedback_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $feedback = isset($body['feedback']) ? trim((string)$body['feedback']) : '';
        $standardsOk = isset($body['standardsOk']) ? (bool)$body['standardsOk'] : false;
        $suggestedCourses = isset($body['suggestedCourses']) ? (string)$body['suggestedCourses'] : '';
        $ratingInstructor = isset($body['ratingInstructor']) ? (int)$body['ratingInstructor'] : 0;
        $ratingLocation = isset($body['ratingLocation']) ? (int)$body['ratingLocation'] : 0;

        if ($recordId <= 0 || $feedback === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
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

        return new JsonResponse([
            'status'  => 'success',
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
        if (! $this->configurationService->isFeatureEnabled('feedback_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $recordId = isset($params['recordId']) ? (int)$params['recordId'] : 0;
        if ($recordId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.feedback.invalidRecordId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $submitted = $this->feedbackService->isFeedbackSubmitted($userId, $recordId);

        return new JsonResponse([
            'status'            => 'success',
            'feedbackSubmitted' => $submitted,
        ]);
    }
}
// EOF
