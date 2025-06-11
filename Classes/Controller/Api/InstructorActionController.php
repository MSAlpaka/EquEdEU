<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\InstructorServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for instructor-only actions: completing courses and uploading evaluations.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <instructor_actions_api> feature toggle.
 */
final class InstructorActionController extends ActionController
{
    public function __construct(
        private readonly InstructorServiceInterface        $instructorService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
        private readonly Context                           $context
    ) {
        parent::__construct();
    }

    /**
     * Marks a user course record as completed by the instructor.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function completeCourseAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('instructor_actions_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $instructorId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($instructorId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        if ($recordId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.invalidRecordId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $success = $this->instructorService->completeCourse($recordId, $instructorId);
        if (! $success) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.accessDenied')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.instructor.courseCompleted'),
        ]);
    }

    /**
     * Uploads an evaluation note for a user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function uploadEvaluationAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('instructor_actions_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $instructorId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($instructorId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $note = isset($body['evaluationNote']) ? trim((string)$body['evaluationNote']) : '';
        if ($recordId <= 0 || $note === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $success = $this->instructorService->uploadEvaluation($recordId, $instructorId, $note);
        if (! $success) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructor.accessDenied')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.instructor.evaluationUploaded'),
        ]);
    }
}
// EOF
